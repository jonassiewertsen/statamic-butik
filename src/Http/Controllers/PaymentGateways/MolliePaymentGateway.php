<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends WebController implements PaymentGatewayInterface
{
    public function handle() {
        $payment = Mollie::api()->payments()->create([
             'amount' => [
                 'currency' => 'EUR',
                 // You must send the correct number of decimals, thus we enforce the use of strings
                 'value' => '10.00', // TODO: Check if the delimiter can be , or only .
             ],
             'description' => 'My first API payment',
             'webhookUrl' => 'https://563ef0ff.ngrok.io',
//             'webhookUrl' => route('butik.payment.webhook.mollie'),
             'redirectUrl' => 'https://www.google.com', // TODO: Add success route
         ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            dd('yeahhh. Payment did work :-)');
        }
    }
}
