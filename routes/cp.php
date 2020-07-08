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

    Route::get('variants/from/{product}', 'VariantsController@from')
        ->name('variants.from-product');
    Route::resource('variants', 'VariantsController')->only([
       'store', 'update', 'destroy',
    ]);
    Route::get('variants/{product}', 'VariantsController@from')
        ->name('variants.index');

    Route::resource('orders', 'OrdersController')->only([
       'index', 'show',
    ]);

    Route::resource('settings', 'SettingsController')->only([
        'index',
    ]);

    Route::prefix('settings')->group(function() {
        Route::resource('taxes', 'TaxesController')->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);

        Route::get('categories/from/{product}', 'CategoriesController@from')
            ->name('categories.from-product');
        Route::resource('categories', 'CategoriesController')->only([
           'store', 'update', 'destroy',
        ]);

        Route::post('category/{category}/attach/{product}', 'CategoriesController@attachProduct')
            ->name('category.attach-product');

        Route::delete('category/{category}/attach/{product}', 'CategoriesController@detachProduct')
            ->name('category.attach-product');

        Route::resource('countries', 'CountriesController')->only([
           'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        Route::resource('shipping', 'ShippingController')->only([
            'index',
        ]);

        Route::resource('shipping-profiles', 'ShippingProfilesController')->only([
            'index', 'show', 'store', 'update', 'destroy',
        ]);

        Route::resource('shipping-zones', 'ShippingZonesController')->only([
            'store', 'update', 'destroy',
        ]);

        Route::resource('shipping-rates', 'ShippingRatesController')->only([
            'store', 'update', 'destroy'
        ]);

        Route::get('country-shipping-zone/{shippingZone}', 'CountryShippingZoneController@index')
            ->name('country-shipping-zone.index');

        Route::post('country-shipping-zone/{shippingZone}/add/{country}', 'CountryShippingZoneController@store')
            ->name('country-shipping-zone.store');

        Route::delete('country-shipping-zone/{shippingZone}/remove/{country}', 'CountryShippingZoneController@destroy')
            ->name('country-shipping-zone.destroy');
    });
});
