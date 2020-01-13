<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('statamic-butik.uri.prefix'))->name('butik.')->namespace('Http\\Controllers\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');
    Route::get('/{product}', 'ShopController@show')->name('shop.product');
});
