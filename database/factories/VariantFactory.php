<?php

use Faker\Generator as Faker;
use Jonassiewertsen\Butik\Http\Models\Variant;

$factory->define(Variant::class, function (Faker $faker) {
    return [
        'available'     => true,
        'product_slug'  => 'some-slug',
        'title'         => $faker->name,
        'inherit_price' => true,
        'price'         => null,
        'inherit_stock' => false,
        'stock'         => $faker->numberBetween(2, 100),
    ];
});
