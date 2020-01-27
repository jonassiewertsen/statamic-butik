<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

$factory->define(Tax::class, function (Faker $faker) {
    return [
        'title'         => $faker->name,
        'slug'          => $faker->unique()->slug,
        'percentage'    => $faker->numberBetween(0, 25),
    ];
});
