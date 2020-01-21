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
    Route::get(config('statamic-butik.uri.checkout.express.payment'), 'ExpressCheckoutController@payment')->name('checkout.express.payment');
    Route::get(config('statamic-butik.uri.checkout.express.receipt').'/{product}', 'ExpressCheckoutController@receipt')->name('checkout.express.receipt');

    Route::get('payment/process', 'PaymentGatewayController@processPayment')->name('payment.process');
    Route::post('payment/webhook/mollie', 'PaymentGatewayController@webhook')->name('payment.webhook.mollie');

    Route::get('{product}', 'ShopController@show')->name('shop.product');
});
