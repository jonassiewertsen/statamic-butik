<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;

$factory->define(Variant::class, function (Faker $faker) {
    return [
        'available'    => true,
        'product_slug' => create(Product::class)->first(),
        'title'        => $faker->name,
        'stock'        => $faker->numberBetween(2, 100),
    ];
});
