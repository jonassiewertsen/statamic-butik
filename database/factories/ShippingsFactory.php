<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug'  => $faker->slug,
        'price' => $faker->numberBetween(0, 15),
    ];
});
