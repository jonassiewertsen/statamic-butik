<?php
/*
 * You can place your custom package configuration in here.
 */
return [
    // TODO: Remember To enable foreign key constraints

    /**
     * Put your shop information here. Those will fx be shown on the
     * website and the email templates.
     */
    'name' => 'Statamic Butik',
    'thank_you' => 'Thank you!',

    'address_1' => '132 Main Street',
    'address_2' => 'Sea view, Fahrensodde', // can be left empty
    'zip_city' => '24937 Flensburg',
    'country'   => 'Germany',

    'phone' => '+49 1294 238474934',
    'mail' => 'butik@shop.com',

    /**
     * Who should receive mails for successful orders?
     */
    'mail_confirmations' => 'your_mail@butik.com',

    /**
     * useful links here
     * 'link' => 'name',
     */
    'useful_links' => [
//        'https://jonassiewertsen.com'  => 'Jonas Siwertsen',
//        'https://statamic.com'  => 'Statamic',
//        'https://laravel.com'   => 'Laravel',
    ],


    /**
     * All of your Payment Gateway options. If you need to adjust them, it's best
     * to do so in your .env file.
     */
    'payment'  => [
        'mollie' => [
            'key' => env('MOLLIE_KEY', ''),
        ],
    ],

    /**
     * Define your shops currency
     */
    'currency' => [
        'name'      => 'Euro',
        'isoCode'   => 'EUR', // Make sure to use  ISO_4217 https://en.wikipedia.org/wiki/ISO_4217
        'symbol'    => '€',
        'delimiter' => ',',
    ],

    'widgets' => [
        'orders' => [
            'limit' => 10,
        ]
    ],

    /**
     * Define your own custom route name to view the Statamic Butik
     * on the front-end.
     */
    'uri'      => [
        'shop'     => '/shop',
        'checkout' => [
            'express' => [
                'delivery' => 'express-checkout/delivery',
                'payment'  => 'express-checkout/payment',
            ],
        ],
        'payment' => [
            'receipt'   => 'payment/{order}/receipt',
        ]
    ],
    'frontend' => [
        'layout'   => [
            'overview' => 'statamic-butik::web.layouts.shop',
            'show'     => 'statamic-butik::web.layouts.shop',
            'checkout' => [
                'express' => [
                    'delivery' => 'statamic-butik::web.layouts.express-checkout',
                    'payment'  => 'statamic-butik::web.layouts.express-checkout',
                    'receipt'  => 'statamic-butik::web.layouts.express-checkout',
                ],
            ],
        ],
        'template' => [
            'overview' => 'statamic-butik::web.shop.overview',
            'show'     => 'statamic-butik::web.shop.show',
            'checkout' => [
                'express' => [
                    'delivery' => 'statamic-butik::web.checkout.express.delivery',
                    'payment'  => 'statamic-butik::web.checkout.express.payment',
                ],
                'receipt'         => 'statamic-butik::web.checkout.receipt',
                'invalidReceipt'  => 'statamic-butik::web.checkout.invalidReceipt',
            ],
        ],
    ],
];
