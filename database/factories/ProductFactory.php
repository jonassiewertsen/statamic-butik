<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'           => $faker->name,
        'slug'           => $faker->unique()->slug,
        'description'    => $faker->paragraph(3)
    ];
});
