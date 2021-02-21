<?php

use App\Http\Middleware\VerifyCsrfToken;

Route::namespace('\Jonassiewertsen\StatamicButik\Http\Controllers\Web')
    ->prefix(locale_url().'/'.config('butik.route_shop-prefix'))
    ->middleware(['web', 'butikRoutes'])
    ->name('butik.')
    ->group(function () {

        /**
         * #################################################################################################################
         *   Shopping Cart
         * #################################################################################################################.
         */
        Route::get(config('butik.route_cart'), 'CartController@index')
            ->name('cart');

        /**
         * #################################################################################################################
         *   Payment receipt page
         * #################################################################################################################.
         */
        Route::get(config('butik.route_payment-receipt'), 'CheckoutController@receipt')
            ->name('payment.receipt');

        /**
         * #################################################################################################################
         *   Checkout routes
         * #################################################################################################################.
         */
        Route::get(config('butik.route_checkout-delivery'), 'CheckoutController@delivery')
            ->name('checkout.delivery')
            ->middleware('cartNotEmpty');

        Route::post(config('butik.route_checkout-delivery'), 'CheckoutController@storeCustomerData')
            ->name('checkout.delivery.store')
            ->middleware('cartNotEmpty');

        Route::get(config('butik.route_checkout-payment'), 'CheckoutController@payment')
            ->name('checkout.payment')
            ->middleware(['cartNotEmpty', 'validateCheckoutRoute']);

        Route::get('process/payment', 'PaymentGatewayController@processPayment')
            ->name('payment.process')
            ->middleware(['cartNotEmpty', 'validateCheckoutRoute']);
    });

/**
 * #################################################################################################################
 *   Mollie webhook
 * #################################################################################################################.
 */
Route::post('butik/webhook/mollie', '\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\Web\\PaymentGatewayController@webhook')
    ->name('butik.payment.webhook.mollie')
    ->withoutMiddleware([VerifyCsrfToken::class]);
