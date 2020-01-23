<?php

/*
|--------------------------------------------------------------------------
| CP routes
|--------------------------------------------------------------------------
*/

Route::prefix('butik/')->name('butik.')->namespace('Http\\Controllers\\CP\\')->group(function() {
    Route::resource('products', 'ProductsController')->only([
       'index', 'create', 'store', 'edit',  'update', 'destroy',
    ]);

    Route::resource('orders', 'OrdersController')->only([
       'index',
    ]);

    Route::prefix('/settings')->group(function() {
        Route::resource('taxes', 'TaxesController')->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);

        Route::resource('shippings', 'ShippingsController')->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);
    });
});
