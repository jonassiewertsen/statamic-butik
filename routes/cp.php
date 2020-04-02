<?php

/*
|--------------------------------------------------------------------------
| CP routes
|--------------------------------------------------------------------------
*/

// TODO: Choose a better namespace, when addon testing has been streamlined
Route::prefix('butik/')->name('butik.')->namespace('\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\CP\\')->group(function() {

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
    });

});
