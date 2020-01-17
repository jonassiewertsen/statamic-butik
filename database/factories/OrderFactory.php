<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
user Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->uuid,
        'products'  => json_encode(create(Product::class)),
        'total_amount' => $faker->numberBetween(20, 150),
        'paid_at' => $faker->dateTimeBetween(now()->subMonth(), now()),
        'shipped_at' => null,
    ];
});