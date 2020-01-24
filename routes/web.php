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

    Route::get(config('statamic-butik.uri.payment.receipt'), 'ExpressCheckoutController@receipt')->name('payment.receipt');
    Route::get('payment/process', 'PaymentGatewayController@processPayment')->name('payment.process')->middleware('signed');

    Route::get('{product}', 'ShopController@show')->name('shop.product');
});

// Webhook without butik prefix
Route::post('payment/webhook/mollie', 'Http\\Controllers\\Web\\PaymentGatewayController@webhook')->name('butik.payment.webhook.mollie');
