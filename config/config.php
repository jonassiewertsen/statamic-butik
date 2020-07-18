<?php

return [

    /**
     * More detailed information can be found here:
     * https://butik.dev/installation/configuration
     *
     *
     * SHOP INFORMATION
     *
     * Put your shop information here. Those information will be usedby templates for the shop and emails.
     */
    'name'     => 'Statamic Butik', // Whats the name of your Shop?
    'address1' => '132 Main Street',
    'address2' => 'Sea view, Fahrensodde', // can be left empty
    'zip_city' => '24937 Flensburg',
    'country'  => 'Germany', // Set your default country
    'phone'    => '+49 1294 238474934',
    'mail'     => 'butik@shop.com',

    /**
     * Shop overview
     *
     * What should be displayed on the start page of butik?
     *
     * all:      All products ordered by name. The limit will be ignored.
     * name:     All products ordered by name. The limit will be respected.
     * newest:   Showing the latest added products
     * cheapest: Showing products with the best price first.
     *
     */
    'overview_type'    => 'newest',
    'overview_limit'   => '6',

    /**
     * MAIL
     *
     * Butik will send one confirmation email for every sold product to this address.
     */
    'order-confirmations' => 'your_mail@butik.com',

    /**
     * USEFUL LINKS
     *
     * Your mails will contain a useful links section at the buttom. Only if you want to.
     * This could be a good spot to give your customer more information about your
     * products, shipping information, refund informations etc ...
     *
     * 'link' => 'name to be shown',
     */
    'useful-links' => [
//        'https://butik.dev'    => 'Butik documentation',
//        'https://statamic.com' => 'Statamic Website',
    ],

    /**
     * CURRENCY
     *
     * Define your shops currency
     */
    'currency_name'      => 'Euro',
    'currency_isoCode'   => 'EUR', // Make sure to use ISO_4217 https://en.wikipedia.org/wiki/ISO_4217
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
    'route_shop-prefix'       => 'shop',                       // yourshop.com/shop/
    'route_cart'              => 'cart',                       // yourshop.com/shop/cart
    'route_category'          => 'category/{category}',         // yourshop.com/shop/category/xxxxx
    'route_checkout-delivery' => 'checkout/delivery',           // yourshop.com/shop/checkout/delivery
    'route_checkout-payment'  => 'checkout/payment',            // yourshop.com/shop/checkout/payment
    'route_payment-receipt'   => 'payment/{order}/receipt',     // yourshop.com/shop/payment/xxxxx/receipt

    /**
     * TEMPLATES
     *
     * Define your own templates for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'template_product-index'            => 'butik::web.shop.index',
    'template_product-category'         => 'butik::web.shop.category',
    'template_product-show'             => 'butik::web.shop.show',
    'template_cart'                     => 'butik::web.cart.index',
    'template_checkout-delivery'        => 'butik::web.checkout.delivery',
    'template_checkout-payment'         => 'butik::web.checkout.payment',
    'template_checkout-receipt'         => 'butik::web.checkout.receipt',
    'template_checkout-receipt-invalid' => 'butik::web.checkout.invalid-receipt',

    /**
     * LAYOUTS
     *
     * Define your own layouts for the frontend if you want. You can as well edit the
     * given layouts to fit your needs.
     */
    'layout_product-index'            => 'layout',
    'layout_product-category'         => 'layout',
    'layout_product-show'             => 'layout',
    'layout_cart'                     => 'layout',
    'layout_checkout-delivery'        => 'layout',
    'layout_checkout-payment'         => 'layout',
    'layout_checkout-receipt'         => 'layout',
    'layout_checkout-receipt-invalid' => 'layout',

    /**
     * SHIPPING
     *
     * If you want, you can implement your own shipping methods or disable those, you don't want to use.
     * https://butik.dev/configuration/shipping
     */
    'shipping' => [
        'price' => \Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice::class,
    ],

    /**
     * PAYMENT
     *
     * If you want, you can swap our payment gateway with your own integration.
     * https://butik.dev/extending/payment-gateway
     */
    'payment_gateway' => Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway::class,
];
