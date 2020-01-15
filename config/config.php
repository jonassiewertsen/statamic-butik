<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // TODO: Remember To enable foreign key constraints
    // https://laravel.com/docs/6.x/database

    /**
     * All of your Payment Gateway options. If you need to adjust them, it's best
     * to do so in your .env file.
     */
    'payment' => [
        'braintree' =>  [
            'env'           => env('BRAINTREE_ENV', 'sandbox'),
            'merchant_id'   => env('BRAINTREE_MERCHANT_ID', null),
            'public_key'    => env('BRAINTREE_PUBLIC_KEY', null),
            'private_key'   => env('BRAINTREE_PRIVATE_KEY', null),
        ]
    ],

    /**
     * Define your shops currency
     */
    'currency' => [
        'name' => 'Euro',
        'symbol' => '€',
        'delimiter' => ',',
    ],

    /**
     * Define your own custom route name to view the Statamic Butik
     * on the front-end.
     */
    'uri' => [
        'shop' => '/shop',
        'checkout' => [
            'express' => [
                'delivery' => 'express-checkout/delivery',
                'payment' => 'express-checkout/payment',
            ]
        ],
        'payment' => [
            'process' => 'payment/process',
            'receipt' => 'express-checkout/receipt',
        ]
    ],

    'frontend' => [
        'layout' => [
            'overview' => 'statamic-butik::web.layouts.shop',
            'show'     => 'statamic-butik::web.layouts.shop',
            'checkout' => [
                'express' => [
                    'delivery' => 'statamic-butik::web.layouts.express-checkout',
                    'payment' => 'statamic-butik::web.layouts.express-checkout',
                ]
            ]
        ],
        'template' => [
            'overview' => 'statamic-butik::web.shop.overview',
            'show'     => 'statamic-butik::web.shop.show',
            'checkout' => [
                'express' => [
                    'delivery' => 'statamic-butik::web.checkout.express.delivery',
                    'payment' => 'statamic-butik::web.checkout.express.payment',
                ]
            ]
        ]
    ]
];
