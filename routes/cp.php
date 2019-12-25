<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Jonassiewertsen\StatamicButik\Http\Controllers\ProductsController;

Route::prefix('cp/butik/')->name('butik.')->group(function() {
    Route::get('product/create', [ProductsController::class, 'create'])->name('product.create');
    Route::post('product/create', [ProductsController::class, 'store'])->name('product.store');
});
