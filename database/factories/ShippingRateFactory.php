<?php

use Faker\Generator as Faker;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;

$factory->define(ShippingRate::class, function (Faker $faker) {
    return [
        'shipping_zone_id' => create(ShippingZone::class)->first(),
        'title'            => $faker->word,
        'price'            => $faker->numberBetween(100, 1000),
        'minimum'          => $faker->numberBetween(0, 500),
    ];
});
