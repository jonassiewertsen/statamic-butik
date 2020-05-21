<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

$factory->define(ShippingRate::class, function (Faker $faker) {
    return [
        'shipping_zone_slug' => create(ShippingZone::class)->first(),
        'title'              => $faker->word,
        'price'              => $faker->numberBetween(100, 1000),
        'minimum'            => $faker->numberBetween(0, 500),
        'maximum'            => $faker->numberBetween(1000, 5000),
        'type'               => 'price',
    ];
});
