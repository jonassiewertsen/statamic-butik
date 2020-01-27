<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Traits\MollyLocale;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends WebController implements PaymentGatewayInterface
{
    use MollyLocale;

    public function handle(Cart $cart) {
        $mollieCustomer = Mollie::api()->customers()->create([
            'name' => $cart->customer->name,
            'email' => $cart->customer->mail,
       ]);

        $orderId = str_random(20);

        $payment = Mollie::api()
            ->payments()
            ->create($this->paymentInformation($cart, $mollieCustomer, $orderId));

        $payment = Mollie::api()->payments()->get($payment->id);
        event(new PaymentSubmitted($payment, $cart, $orderId));

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            $this->setOrderStatusToPaid($payment);
            event(new PaymentSuccessful($payment));
        }

        if ($payment->isFailed()) {
            $this->setOrderStatusToFailed($payment);
        }

        if ($payment->isExpired()) {
            $this->setOrderStatusToExpired($payment);
        }

        if ($payment->isCanceled()) {
            $this->setOrderStatusToCanceled($payment);
        }
    }

    private function convertAmount($amount) {
        return number_format(floatval($amount), 2, '.', '');
    }

    private function setOrderStatusToPaid($payment): void {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'paid',
           'paid_at' => Carbon::parse($payment->paidAt)
       ]);
    }

    private function setOrderStatusToFailed($payment): void {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'failed',
           'failed_at' => Carbon::parse($payment->failedAt)
       ]);
    }

    private function setOrderStatusToExpired($payment): void {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
            'status' => 'expired',
        ]);
    }

    private function setOrderStatusToCanceled($payment): void {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'canceled',
       ]);
    }

    private function paymentInformation($cart, $mollieCustomer, $orderId){
        $product = $cart->products->first();

        $payment = [
            'description' => $product->title,
            'customerId' => $mollieCustomer->id,
            'metadata' => 'Express Checkout: '. $product->title,
            'locale' => $this->getLocale(),
            'redirectUrl' =>  URL::temporarySignedRoute('butik.payment.receipt', now()->addMinutes(5), ['order' => $orderId]),
            'amount' => [
                'currency' => config('butik.currency.isoCode'),
                'value' => $this->convertAmount($product->totalPrice),
            ],
        ];

        // Only adding the webhook when not in local environment
        if (! App::environment(['local'])) {
            $payment = array_merge($payment, [
                'webhookUrl' => route('butik.payment.webhook.mollie'),
            ]);
        }

        return $payment;
    }
}
