<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Statamic\Support\Str;

$factory->define(Country::class, function (Faker $faker) {
    $name = $faker->country;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'iso'  => $faker->countryCode,
    ];
});
