<?php

// TODO: Choose a better namespace, when addon testing has been streamlined
Route::prefix(config('butik.route_shop-prefix'))->name('butik.')->middleware('web')->namespace('\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\Web\\')->group(function() {

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
    Route::get(config('butik.route_payment-receipt'), 'ExpressCheckoutController@receipt')

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


    Route::get('process/express-payment', 'PaymentGatewayController@processPayment')
        ->name('payment.process')
        ->middleware(['cartNotEmpty', 'validateCheckoutRoute']);

    /**
     * #################################################################################################################
     *   Express Checkout routes
     * #################################################################################################################
     */
    Route::get(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@delivery')
        ->name('checkout.express.delivery');

    Route::post(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@saveCustomerData')
        ->name('checkout.express.delivery');

    Route::get(config('butik.route_express-checkout-payment').'/{product}', 'ExpressCheckoutController@payment')
        ->name('checkout.express.payment')
        ->middleware('validateExpressCheckoutRoute');

    Route::get('process/express-payment/{product}', 'PaymentGatewayController@processExpressPayment')
        ->name('payment.express.process')
        ->middleware('validateExpressCheckoutRoute');

    /**
     * #################################################################################################################
     *   Shop pages
     * #################################################################################################################
     */
    Route::get('/', 'ShopController@index')
        ->name('shop');

    Route::get('{product}', 'ShopController@show')
        ->name('shop.product');

    /**
     * #################################################################################################################
     *   Mollie webhook
     * #################################################################################################################
     */
    Route::post('payment/webhook/mollie', '\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\Web\\PaymentGatewayController@webhook')
        ->name('payment.webhook.mollie');
});
