<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'id'           => $faker->unique()->uuid,
        'status'       => 'open',
        'method'       => 'paypal',
        'products'     => json_encode(create(Product::class)),
        'customer'     => json_encode(create(Customer::class)->first()),
        'total_amount' => $faker->numberBetween(20, 150),
        'created_at'   => $faker->dateTimeBetween(now()->subMonth(), now()),
        'paid_at'      => null,
        'shipped_at'   => null,
    ];
});