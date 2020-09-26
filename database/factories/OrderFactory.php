<?php

use Faker\Generator as Faker;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Order\ItemCollection;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;

$factory->define(Order::class, function (Faker $faker) {
    $this->slug = str_random(4);

    Collection::make('products')->save();

    Entry::make()
        ->collection('products')
        ->blueprint('products')
        ->slug($this->slug)
        ->date(now())
        ->data([
            'title'  => 'Test Item Product',
            'price'  => '20.00',
            'stock'  => '5',
            'tax_id' => create(Tax::class)->first()->slug,
            'images' => collect(['someimage.png']),
        ])
        ->save();

    $product = Product::find($this->slug);
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
