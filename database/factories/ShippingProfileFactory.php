<?php

use Faker\Generator as Faker;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Statamic\Support\Str;

$factory->define(ShippingProfile::class, function (Faker $faker) {
    $title = $faker->unique()->word;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
    ];
});
