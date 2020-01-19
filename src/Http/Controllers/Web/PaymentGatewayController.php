<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\PaymentGateways\BraintreePaymentGateway;

class PaymentGatewayController extends WebController
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new MolliePaymentGateway();
    }

    public function processPayment(Request $request)
    {
        $payment = Mollie::api()->payments()->create([
             'amount' => [
                 'currency' => 'EUR',
                 'value' => '10.00', // You must send the correct number of decimals, thus we enforce the use of strings
             ],
             'description' => 'My first API payment',
             'webhookUrl' => route('webhooks.mollie'),
             'redirectUrl' => route('order.success'),
         ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    private function saveTransactionInSession($response) {
        $customer = session()->pull('butik.customer');

        Session::put(
            'butik.transaction', collect([
                // TODO: save the product slug as well
                'success'         => $response->success,
                'id'              => $response->transaction->id,
                'type'            => $response->transaction->type,
                'currencyIsoCode' => $response->transaction->currencyIsoCode,
                'amount'          => $response->transaction->amount,
                'created_at'      => Carbon::parse($response->transaction->createdAt),
                'customer'        => $customer,
            ]));
    }
}
