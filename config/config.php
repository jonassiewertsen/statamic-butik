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
    'mail_confirmations' => 'your_mail@butik.com',

    /**
     * USEFUL LINKS
     *
     * Your mails will contain a useful links section at the buttom. Only if you want to.
     * This could be a good spot to give your customer more information about your
     * products, more shipping information, refund informations etc ...
     *
     * 'link' => 'name to be shown',
     */
    'useful_links' => [
//        'https://mywebsite.com/shipping'  => 'Shipping',
//        'https://mywebsite.com/refunds'   => 'Refunds',
    ],

    /**
     * CURRENCY
     *
     * Define your shops currency
     */
    'currency' => [
        'name'      => 'Euro',
        'isoCode'   => 'EUR', // Make sure to use  ISO_4217 https://en.wikipedia.org/wiki/ISO_4217
        'symbol'    => '€',
        'delimiter' => ',',
    ],

    /**
     * WIDGETS
     *
     * Settings for your dashboard widgets
     */
    'widgets' => [
        'orders' => [
            'limit' => 10,
        ]
    ],

    /**
     * ROUTING
     *
     * Define your own custom route names to view the Statamic Butik
     * on the front-end.
     */
    'uri'      => [
        /* Here we will show all available products  */
        /* It will be the prefix to all other routes too  */
        'shop'     => '/shop',

        /* Checkout & payment routes */
        'checkout' => [
            'express' => [
                'delivery' => 'express-checkout/delivery', // yourshop.com/shop/express-checkout/delivery
                'payment'  => 'express-checkout/payment', // yourshop.com/shop/express-checkout/payment
            ],
        ],
        'payment' => [
            'receipt' => 'payment/{order}/receipt', // yourshop.com/shop/payment/xxxxxxxxx/receipt
        ]
    ],

    /**
     * LAYOUTS
     *
     * Define your own layouts for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'layout'   => [
        'product-overview'          => 'butik::web.layouts.shop',
        'product-show'              => 'butik::web.layouts.shop',
        'express-checkout-delivery' => 'butik::web.layouts.express-checkout',
        'express-checkout-payment'  => 'butik::web.layouts.express-checkout',
        'checkout-receipt'          => 'butik::web.layouts.express-checkout',
    ],

    /**
     * TEMPLATES
     *
     * Define your own templates for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'template' => [
        'product-overview'          => 'butik::web.shop.overview',
        'product-show'              => 'butik::web.shop.show',
        'express-checkout-delivery' => 'butik::web.checkout.express.delivery',
        'express-checkout-payment'  => 'butik::web.checkout.express.payment',
        'checkout-receipt'          => 'butik::web.checkout.receipt',
        'checkout-receipt-invalid'  => 'butik::web.checkout.invalidReceipt',
    ],

    /**
     * PAYMENT GATEWAY
     *
     * All of your Payment Gateway options. If you need to adjust them, it's best
     * to do so in your .env file.
     */
    'payment'  => [
        'mollie' => [
            'key' => env('MOLLIE_KEY', ''),
        ],
    ],
];
