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

        Route::resource('shippings', 'ShippingsController')->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);

        Route::resource('countries', 'CountriesController')->only([
           'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        Route::resource('shipping-profiles', 'ShippingProfilesController')->only([
            'store', 'update', 'destroy',
        ]);
    });
});
