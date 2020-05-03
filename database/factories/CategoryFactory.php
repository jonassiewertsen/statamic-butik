<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Statamic\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->colorName;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
