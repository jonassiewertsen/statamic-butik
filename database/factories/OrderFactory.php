<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

$factory->define(Order::class, function (Faker $faker) {
    $items = new Item(create(Product::class)->first());
    $items = collect()->push($items);

    $transaction = (new Transaction())->items($items);

    return [
        'id'                => str_random(20),
        'transaction_id'    => 'tr_'. str_random(8),
        'status'            => 'open',
        'method'            => 'paypal',
        'items'             => json_encode($transaction->items),
        'customer'          => json_encode([
            'name'              => 'Jonas Siewertsen',
            'mail'              => 'something@mail.com',
            'address1'          => 'Dorfstrasse 4',
            'address2'          => 'Hinterhaus',
            'zip'               => '23454',
            'city'              => 'Flensburg',
            'country'           => 'Deutschland',
        ]),
        'total_amount'      => $faker->numberBetween(20, 150),
        'created_at'        => $faker->dateTimeBetween(now()->subMonth(), now()),
        'paid_at'           => null,
        'shipped_at'        => null,
    ];
});
