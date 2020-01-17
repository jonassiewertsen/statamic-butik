<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title'          => $faker->name,
        'slug'           => $faker->unique()->slug,
        'description'    => $faker->paragraph(3),
        'base_price'     => $faker->numberBetween(100, 20000),
        'tax_id'         => create(Tax::class)->first(),
        'shipping_id'    => create(Shipping::class)->first(),
        'type'           => $faker->randomElement(['download', 'physical'])
    ];
});
