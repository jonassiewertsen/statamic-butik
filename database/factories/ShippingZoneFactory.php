<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\Support\Str;

$factory->define(ShippingZone::class, function (Faker $faker) {
    $title = $faker->word;

    return [
        'title'                 => $title,
        'slug'                  => Str::slug($title),
        'shipping_profile_slug' => create(ShippingProfile::class)->first(),
    ];
});
