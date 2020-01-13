<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // TODO: Remember To enable foreign key constraints
    // https://laravel.com/docs/6.x/database

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
        'prefix' => 'shop',
        'checkout' => [
            'express' => 'express-checkout',
        ]
    ]
];
