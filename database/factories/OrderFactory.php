<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'id'           => 'tr_'. str_random(8),
        'status'       => 'open',
        'method'       => 'paypal',
        'products'     => json_encode(create(Product::class)),
        'customer'     => json_encode(['name' => 'John Doe', 'mail' => 'doe@john.com']),
        'total_amount' => $faker->numberBetween(20, 150),
        'created_at'   => $faker->dateTimeBetween(now()->subMonth(), now()),
        'paid_at'      => null,
        'shipped_at'   => null,
    ];
});