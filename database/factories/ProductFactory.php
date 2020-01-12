<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title'          => $faker->name,
        'slug'           => $faker->unique()->slug,
        'description'    => $faker->paragraph(3),
//        'images'         => array($faker->imageUrl()), // TODO: Does throw error on testing
        'base_price'     => $faker->numberBetween(100, 20000),
        'type'           => $faker->randomElement(['download', 'physical'])
    ];
});
