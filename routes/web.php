<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('statamic-butik.uri.prefix'))->name('butik.')->namespace('Http\\Controllers\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');
    Route::get('{product}', 'ShopController@show')->name('shop.product');

    Route::get(config('statamic-butik.uri.checkout.express.delivery').'/{product}', 'ExpressCheckoutController@delivery')->name('checkout.express.delivery');
    Route::post(config('statamic-butik.uri.checkout.express.delivery').'/{product}', 'ExpressCheckoutController@customerData')->name('checkout.express.delivery');
    Route::get(config('statamic-butik.uri.checkout.express.payment').'/{product}', 'ExpressCheckoutController@payment')->name('checkout.express.payment');

    Route::get(config('statamic-butik.uri.payment.process'), 'PaymentGatewayController@processPayment')->name('payment.process');
    Route::get(config('statamic-butik.uri.payment.receipt'), 'PaymentGatewayController@receipt')->name('payment.receipt');
});
