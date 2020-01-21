<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentGateway extends WebController implements PaymentGatewayInterface
{
    public function handle(Cart $cart) {
        $customer = Mollie::api()->customers()->create([
            'name' => $cart->customer->name,
            'email' => $cart->customer->mail,
       ]);

        $product = $cart->products->first();

        $payment = Mollie::api()->payments()->create([
             'description' => $product->title,
             'customerId' => $customer->id,
             'metadata' => 'Express Checkout: '. $product->title,
             'locale' => $this->getLocale(),
             // TODO: The verify csrf tooken needs to be disabled. Put into Documentation !!!
             'webhookUrl' => route('butik.payment.webhook.mollie'),
             'redirectUrl' => 'https://statamic.test/shop',

             'amount' => [
                 'currency' => config('statamic-butik.currency.isoCode'),
                 // TODO: Refactor cart to return the total price
                 'value' => $this->convertAmount($product->totalPrice),

             ],
         ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        // TODO: Some error handling
        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            event(PaymentSuccessful::class);
        }
    }

    private function convertAmount($amount) {
        return number_format(floatval($amount), 2, '.', '');
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
