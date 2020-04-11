<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

// TODO: Choose a better namespace, when addon testing has been streamlined
Route::prefix(config('butik.route_shop-prefix'))->name('butik.')->namespace('\\Jonassiewertsen\\StatamicButik\\Http\\Controllers\\Web\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');

    Route::get('/', 'ShopController@index')->name('shop');
    Route::get(config('butik.route_cart'), 'CartController@index')->name('cart');
    Route::post(config('butik.route_cart') . '/add/{product}', 'CartController@add')->name('cart.add');

    Route::get(config('butik.route_payment-receipt'), 'ExpressCheckoutController@receipt')->name('payment.receipt');

    Route::get(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@delivery')->name('checkout.express.delivery');
    Route::post(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@saveCustomerData')->name('checkout.express.delivery');
    Route::get(config('butik.route_express-checkout-payment').'/{product}', 'ExpressCheckoutController@payment')->name('checkout.express.payment')->middleware('validateExpressCheckoutRoute');
    Route::get('payment/process', 'PaymentGatewayController@processPayment')->name('payment.process')->middleware('validateExpressCheckoutRoute');

    Route::get('{product}', 'ShopController@show')->name('shop.product');
});

// Webhook without butik prefix
Route::post('payment/webhook/mollie', 'Http\\Controllers\\Web\\PaymentGatewayController@webhook')->name('butik.payment.webhook.mollie');
