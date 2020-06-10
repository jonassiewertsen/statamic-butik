<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'available'             => true,
        'title'                 => $faker->name,
        'slug'                  => $faker->unique()->slug,
        'description'           => $faker->paragraph(3),
        'base_price'            => $faker->numberBetween(100, 20000),
        'tax_id'                => create(Tax::class)->first(),
        'shipping_profile_slug' => create(ShippingProfile::class)->first(),
        'stock'                 => $faker->numberBetween(2, 100),
        'stock_unlimited'       => false,
        'type'                  => $faker->randomElement(
            [
                'download',
                'physical',
            ]),
    ];
});
