<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

$factory->define(ShippingRate::class, function (Faker $faker) {
    return [
        'shipping_zone_id' => create(ShippingZone::class)->first(),
        'title'            => $faker->word,
        'price'            => $faker->numberBetween(100, 1000),
        'minimum'          => $faker->numberBetween(0, 500),
        'type'             => 'price',
    ];
});
