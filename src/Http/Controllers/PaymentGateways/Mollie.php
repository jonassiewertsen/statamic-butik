<?php

namespace Jonassiewertsen\StatamicButik\Http\PaymentGateways;

use Illuminate\Http\Request;
use Braintree_Gateway;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;

class Mollie extends WebController implements PaymentGatewayInterface
{
    public function handle(Request $request) {
        $payment = Mollie::api()->payments()->create([
             'amount' => [
                 'currency' => 'EUR',
                 // You must send the correct number of decimals, thus we enforce the use of strings
                 'value' => '10.00', // TODO: Check if the delimiter can be , or only .
             ],
             'description' => 'My first API payment',
             'webhookUrl' => route('webhooks.mollie'),
             'redirectUrl' => route('order.success'),
         ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }
}
