<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends WebController implements PaymentGatewayInterface
{
    private function paymentInformation($cart, $mollieCustomer){
        $product = $cart->products->first();

        $payment = [
            'description' => $product->title,
            'customerId' => $mollieCustomer->id,
            'metadata' => 'Express Checkout: '. $product->title,
            'locale' => $this->getLocale(),
            'redirectUrl' => 'https://statamic.test/shop',
            'amount' => [
                'currency' => config('statamic-butik.currency.isoCode'),
                'value' => $this->convertAmount($product->totalPrice),
            ],
        ];

        // Only adding the webhook when not in local environment
        if (! App::environment(['local'])) {
            array_push($payment, [
                'webhookUrl' => route('butik.payment.webhook.mollie'),
            ]);
        }

        return $payment;
    }

    public function handle(Cart $cart) {
        $mollieCustomer = Mollie::api()->customers()->create([
            'name' => $cart->customer->name,
            'email' => $cart->customer->mail,
       ]);

        $payment = Mollie::api()->payments()->create($this->paymentInformation($cart, $mollieCustomer));

        $payment = Mollie::api()->payments()->get($payment->id);
        event(new PaymentSubmitted($payment, $cart));

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
        $order = Order::whereId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'paid',
           'paid_at' => Carbon::parse($payment->paidAt)
       ]);
    }

    private function setOrderStatusToFailed($payment): void {
        $order = Order::whereId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'failed',
           'failed_at' => Carbon::parse($payment->failedAt)
       ]);
    }

    private function setOrderStatusToExpired($payment): void {
        $order = Order::whereId($payment->id)->firstOrFail();
        $order->update([
            'status' => 'expired',
        ]);
    }

    private function setOrderStatusToCanceled($payment): void {
        $order = Order::whereId($payment->id)->firstOrFail();
        $order->update([
           'status' => 'canceled',
       ]);
    }

    private function getLocale() {

        switch (app()->getLocale()) {
            case 'en':
                return 'en_US';
                break;
            case 'nl':
                return 'nl_NL';
                break;
            case 'fr':
                return 'fr_FR';
                break;
            case 'de':
                return 'de_DE';
                break;
            case 'es':
                return 'es_ES';
                break;
            case 'ca':
                return 'ca_ES';
                break;
            case 'pt':
                return 'pt_PT';
                break;
            case 'it':
                return 'it_IT';
                break;
            case 'bn':
                return 'nb_NO';
                break;
            case 'sv':
                return 'sv_SE';
                break;
            case 'fi':
                return 'fi_FI';
                break;
            case 'da':
                return 'da_DK';
                break;
            case 'is':
                return 'is_IS';
                break;
            case 'hu':
                return 'hu_HU';
                break;
            case 'pl':
                return 'pl_PL';
                break;
            case 'lv':
                return 'lv_LV';
                break;
            case 'lt':
                return 'lt_LT';
                break;
            default:
                return 'en_US';
        }
    }
}
