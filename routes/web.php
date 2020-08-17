<?php

use App\Http\Middleware\VerifyCsrfToken;

Route::namespace('\Jonassiewertsen\StatamicButik\Http\Controllers\Web')
    ->prefix(config('butik.route_shop-prefix'))
    ->middleware(['web', 'butikRoutes'])
    ->name('butik.')
    ->group(function() {

    /**
     * #################################################################################################################
     *   Shopping Cart
     * #################################################################################################################
     */
    Route::get(config('butik.route_cart'), 'CartController@index')
        ->name('cart');

    /**
     * #################################################################################################################
     *   Payment receipt page
     * #################################################################################################################
     */
    Route::get(config('butik.route_payment-receipt'), 'CheckoutController@receipt')
        ->name('payment.receipt');

    /**
     * #################################################################################################################
     *   Checkout routes
     * #################################################################################################################
     */
    Route::get(config('butik.route_checkout-delivery'), 'CheckoutController@delivery')
        ->name('checkout.delivery')
        ->middleware('cartNotEmpty');

    Route::post(config('butik.route_checkout-delivery'), 'CheckoutController@saveCustomerData')
        ->name('checkout.delivery')
        ->middleware('cartNotEmpty');

    Route::get(config('butik.route_checkout-payment'), 'CheckoutController@payment')
        ->name('checkout.payment')
        ->middleware(['cartNotEmpty', 'validateCheckoutRoute']);

    Route::get('process/payment', 'PaymentGatewayController@processPayment')
        ->name('payment.process')
        ->middleware(['cartNotEmpty', 'validateCheckoutRoute']);

    /**
     * #################################################################################################################
     *   Shop pages
     * #################################################################################################################
     */
    Route::get('/', 'ShopController@index')
        ->name('shop');

    Route::get(config('butik.route_category'), 'ShopController@category')
        ->name('shop.category');

    Route::get('{product}/{variant?}', 'ShopController@show')
        ->name('shop.product');
});

/**
 * #################################################################################################################
 *   Mollie webhook
 * #################################################################################################################
 */
Route::post('butik/webhook/mollie', '\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\Web\\PaymentGatewayController@webhook')
    ->name('butik.payment.webhook.mollie')
    ->withoutMiddleware([VerifyCsrfToken::class]);
