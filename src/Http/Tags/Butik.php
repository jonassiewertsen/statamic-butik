<?php

namespace Jonassiewertsen\StatamicButik\Http\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Tags\Tags as StatamicTags;

class Butik extends StatamicTags
{
    public function products()
    {
        $products = Product::all();
        $products->transform(function($product) {
            return [
                'title' => $product->title,
                'description' => $product->description,
                'images' => $product->images,
                'base_price' => $product->base_price,
                'show_url' => $product->showUrl(),
            ];
        });
         return $products;
    }

    public function currencySymbol()
    {
        return config('statamic-butik.currency.symbol');
    }
}
