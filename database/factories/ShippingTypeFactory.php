<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingType;
use Statamic\Support\Str;

$factory->define(ShippingType::class, function (Faker $faker) {
    $title = $faker->word;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
    ];
});
