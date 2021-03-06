<?php

use Faker\Generator as Faker;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Http\Models\Tax;

$factory->define(ShippingZone::class, function (Faker $faker) {
    return [
        'title'                 => $faker->word,
        'type'                  => 'price',
        'shipping_profile_slug' => create(ShippingProfile::class)->first(),
        'tax_slug'              => create(Tax::class)->first(),
        'countries'             => ['DE'],
    ];
});
