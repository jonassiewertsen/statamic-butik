<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

$factory->define(Tax::class, function (Faker $faker) {
    return [
        'title'         => $faker->name,
        'price'         => $faker->numberBetween(0, 12),
    ];
});
