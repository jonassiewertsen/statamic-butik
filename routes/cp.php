<?php

/*
|--------------------------------------------------------------------------
| CP routes
|--------------------------------------------------------------------------
*/

Route::namespace('\Jonassiewertsen\StatamicButik\Http\Controllers\CP')
    ->prefix('butik/')
    ->name('butik.')
    ->group(function() {

    Route::resource('products', 'ProductsController')->only([
       'index', 'create', 'store', 'edit',  'update', 'destroy',
    ]);

    Route::resource('orders', 'OrdersController')->only([
       'index', 'show',
    ]);

    Route::prefix('/settings')->group(function() {
        Route::resource('taxes', 'TaxesController')->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);

        Route::resource('countries', 'CountriesController')->only([
           'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        Route::resource('shipping', 'ShippingController')->only([
            'index',
        ]);

        Route::resource('shipping-profiles', 'ShippingProfilesController')->only([
            'index', 'store', 'update', 'destroy',
        ]);

        Route::resource('shipping-zones', 'ShippingZonesController')->only([
            'store', 'update', 'destroy',
        ]);

        Route::resource('shipping-rates', 'ShippingRatesController')->only([
            'store', 'update', 'destroy'
        ]);
    });
});
