<?php

use Faker\Generator as Faker;
use Jonassiewertsen\Butik\Http\Models\Category;
use Statamic\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->name;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
