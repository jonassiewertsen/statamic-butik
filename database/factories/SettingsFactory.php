<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Settings;

$factory->define(Settings::class, function (Faker $faker) {
    return [
        'key' => $faker->word,
        'value'  => $faker->word,
    ];
});
