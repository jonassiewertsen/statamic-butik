<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

use Mollie\Laravel\Facades\Mollie;

Route::prefix(config('statamic-butik.uri.shop'))->name('butik.')->namespace('Http\\Controllers\\Web\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');

    Route::get(config('statamic-butik.uri.checkout.express.delivery').'/{product}', 'ExpressCheckoutController@delivery')->name('checkout.express.delivery');
    Route::post(config('statamic-butik.uri.checkout.express.delivery').'/{product}', 'ExpressCheckoutController@saveCustomerData')->name('checkout.express.delivery');
    Route::get(config('statamic-butik.uri.checkout.express.payment').'/{product}', 'ExpressCheckoutController@payment')->name('checkout.express.payment');
    Route::get(config('statamic-butik.uri.checkout.express.receipt').'/{product}', 'ExpressCheckoutController@receipt')->name('checkout.express.receipt');

    Route::get('payment/process', 'PaymentGatewayController@processPayment')->name('payment.process');

    Route::get('mollie', function() {
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
    });

    Route::get('{product}', 'ShopController@show')->name('shop.product');
});
