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
                'title'           => $product->title,
                'description'     => $product->description,
                'images'          => $product->images,
                'base_price'      => $product->base_price,
                'total_price'     => $product->total_price,
                'shipping_amount' => $product->shipping_amount,
                'tax_amount'      => $product->tax_amount,
                'tax_percentage'  => $product->tax_percentage,
                'show_url'        => $product->showUrl,
            ];

        });

         return $products;
    }

    public function currencySymbol()
    {
        return config('statamic-butik.currency.symbol');
    }

    public function overview()
    {
        return config('statamic-butik.uri.shop');
    }
}
