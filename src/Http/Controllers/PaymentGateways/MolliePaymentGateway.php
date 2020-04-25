<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Traits\MollyLocale;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends WebController implements PaymentGatewayInterface
{
    use MollyLocale, MoneyTrait;

    /**
     * The total amount we will charge the customer with. The price
     * needs to be written with dot notation to make Mollie happy.
     */
    protected string $totalPrice;

    /**
     * All data from this transaction
     */
    protected Transaction $transaction;

    public function handle(Customer $customer, Collection $items, string $totalPrice) {
        $mollieCustomer = Mollie::api()->customers()->create([
            'name' => $customer->name,
            'email' => $customer->mail,
       ]);

        $orderId = str_random(20);
        $this->totalPrice = $totalPrice;

        $payment = Mollie::api()
            ->payments()
            ->create($this->paymentInformation($items, $mollieCustomer, $orderId));

        $payment = Mollie::api()->payments()->get($payment->id);

        $this->transaction = (new Transaction())
            ->id($orderId)
            ->transactionId($payment->id)
            ->method($payment->method ?? '')
            ->totalAmount($payment->amount->value)
            ->createdAt(Carbon::parse($payment->createdAt))
            ->items($items)
            ->customer($customer);

        event(new PaymentSubmitted($this->transaction));

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

    private function paymentInformation($items, $mollieCustomer, $orderId)
    {
        $payment = [
            'description'   => 'ORDER ' . $orderId,
            'customerId'    => $mollieCustomer->id,
            'metadata'      => $this->generateMetaData($items, $orderId),
            'locale'        => $this->getLocale(),
            'redirectUrl'   =>  URL::temporarySignedRoute('butik.payment.receipt', now()->addMinutes(5), ['order' => $orderId]),
            'amount'        => [
                'currency'  => config('butik.currency_isoCode'),
                'value'     => $this->totalPrice,
            ],
        ];


        if (! App::environment(['local'])) {
            // Only adding the mollie webhook, when not in local environment
            $payment = array_merge($payment, [
                'webhookUrl' => route('butik.payment.webhook.mollie'),
            ]);
        } elseif (App::environment(['local']) && $this->ngrokSet()) {
            // When local env and the the NGROK has been set, it will add the ngrok url
            $route = env('MOLLIE_NGROK_REDIRECT') . route('butik.payment.webhook.mollie', [], false);

            $payment = array_merge($payment, [
                'webhookUrl' => $route,
            ]);
        }

        return $payment;
    }

    private function generateMetaData($items, $orderId) {
        $meta = 'ORDER ' . $orderId . ': ';

        foreach ($items as $item) {
            $meta = $meta . $item->getQuantity() . ' x ' . $item->name . '; ';
        }

        return $meta;
    }

    private function ngrokSet(): bool
    {
        return env('MOLLIE_NGROK_REDIRECT', false) == true;
    }
}
