<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\Support\Str;

$factory->define(ShippingZone::class, function (Faker $faker) {
    return [
        'title'                 => $faker->word,
        'shipping_profile_slug' => create(ShippingProfile::class)->first(),
    ];
});
