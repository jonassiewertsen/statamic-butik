<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Order\ItemCollection;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    $product = create(Product::class)->first();
    $items = collect()->push(new Item($product->slug));
    $itemCollection = new ItemCollection($items);

    return [
        'id'                => 'tr_'. str_random(8),
        'number'            => str_random(20),
        'status'            => 'open',
        'method'            => 'paypal',
        'items'             => $itemCollection->items,
        'customer'          => [
            'name'              => 'Jonas Siewertsen',
            'mail'              => 'something@mail.com',
            'address1'          => 'Dorfstrasse 4',
            'address2'          => 'Hinterhaus',
            'zip'               => '23454',
            'city'              => 'Flensburg',
            'country'           => 'Deutschland',
        ],
        'total_amount'      => $faker->numberBetween(20, 150),
        'created_at'        => $faker->dateTimeBetween(now()->subMonth(), now()),
    ];
});
