<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('statamic-butik.uri.prefix'))->name('butik.')->namespace('Http\\Controllers\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');
    Route::get('{product}', 'ShopController@show')->name('shop.product');

    Route::get(config('statamic-butik.uri.checkout.express').'/{product}', 'ExpressCheckoutController@delivery')->name('checkout.express.delivery');
    Route::post(config('statamic-butik.uri.checkout.express').'/{product}', 'ExpressCheckoutController@customerData')->name('checkout.express.delivery');
});
