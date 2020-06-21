<?php

return [

    /**
     * SHOP INFORMATION
     *
     * Put your shop information here. Those information will be used by templates etc.
     */
    'name'      => 'Statamic Butik', // Whats the Name of your Shop?

    'address1'  => '132 Main Street',
    'address2'  => 'Sea view, Fahrensodde', // can be left empty
    'zip_city'  => '24937 Flensburg',
    'country'   => 'Germany', // Right at the moment customer can only order physical products to this country

    'phone'     => '+49 1294 238474934',
    'mail'      => 'butik@shop.com',

    /**
     * MAIL
     *
     * Where to send mail confirmation for successful orders?
     */
    'order-confirmations' => 'your_mail@butik.com',

    /**
     * USEFUL LINKS
     *
     * Your mails will contain a useful links section at the buttom. Only if you want to.
     * This could be a good spot to give your customer more information about your
     * products, more shipping information, refund informations etc ...
     *
     * 'link' => 'name to be shown',
     */
    'useful-links' => [
//        'https://mywebsite.com/shipping'  => 'Shipping',
//        'https://mywebsite.com/refunds'   => 'Refunds',
    ],

    /**
     * CURRENCY
     *
     * Define your shops currency
     */
    'currency_name'      => 'Euro',
    'currency_isoCode'   => 'EUR', // Make sure to use  ISO_4217 https://en.wikipedia.org/wiki/ISO_4217
    'currency_symbol'    => '€',
    'currency_delimiter' => ',',


    /**
     * WIDGETS
     *
     * Settings for your dashboard widgets
     */
    'widget_orders-limit' => 10,

    /**
     * ROUTING
     *
     * Define your own custom route names to view the Statamic Butik
     * on the front-end.
     */
    'route_shop-prefix'               => '/shop',
    'route_cart'                      => '/cart',
    'route_checkout-delivery'         => 'checkout/delivery',           // yourshop.com/shop/checkout/delivery
    'route_checkout-payment'          => 'checkout/payment',            // yourshop.com/shop/checkout/payment
    'route_express-checkout-delivery' => 'express-checkout/delivery',   // yourshop.com/shop/express-checkout/delivery
    'route_express-checkout-payment'  => 'express-checkout/payment',    // yourshop.com/shop/express-checkout/payment
    'route_payment-receipt'           => 'payment/{order}/receipt',     // yourshop.com/shop/payment/xxxxxxxxx/receipt

    /**
     * LAYOUTS
     *
     * Define your own layouts for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'layout_cart'                      => 'butik::web.layouts.shop',
    'layout_product-overview'          => 'butik::web.layouts.shop',
    'layout_product-show'              => 'butik::web.layouts.shop',
    'layout_express-checkout-delivery' => 'butik::web.layouts.express-checkout',
    'layout_express-checkout-payment'  => 'butik::web.layouts.express-checkout',
    'layout_checkout-receipt'          => 'butik::web.layouts.express-checkout',

    /**
     * TEMPLATES
     *
     * Define your own templates for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'template_product-index'             => 'butik::web.shop.index',
    'template_product-show'              => 'butik::web.shop.show',
    'template_cart-index'                => 'butik::web.cart.index',
    'template_checkout-delivery'         => 'butik::web.checkout.delivery',
    'template_checkout-payment'          => 'butik::web.checkout.payment',
    'template_express-checkout-delivery' => 'butik::web.checkout.express-delivery',
    'template_express-checkout-payment'  => 'butik::web.checkout.express-payment',
    'template_checkout-receipt'          => 'butik::web.checkout.receipt',
    'template_checkout-receipt-invalid'  => 'butik::web.checkout.invalid-receipt',

    /**
     * SHIPPING
     *
     * If you want, you can implement your own shipping methods
     */
    'shipping' => [
        'price' => \Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice::class,
    ]
];
