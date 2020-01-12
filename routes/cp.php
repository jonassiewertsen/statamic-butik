<?php

/*
|--------------------------------------------------------------------------
| CP routes
|--------------------------------------------------------------------------
*/

Route::prefix('butik/')->name('butik.')->namespace('Http\\Controllers\\')->group(function() {
    Route::resource('products', 'ProductsController')->only([
       'index', 'create', 'store', 'edit',  'update', 'destroy'
    ]);
});
