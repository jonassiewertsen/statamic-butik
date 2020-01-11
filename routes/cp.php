<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use Jonassiewertsen\StatamicButik\Http\Controllers\ProductsController;

Route::prefix('cp/butik/')->name('butik.')->group(function() {
    Route::get('products/', [ProductsController::class, 'index'])->name('product.index');
    Route::get('products/create', [ProductsController::class, 'create'])->name('product.create');
    Route::post('products/create', [ProductsController::class, 'store'])->name('product.store');
    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('product.destroy');
});
