<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Tags\Tags as StatamicTags;

class Butik extends StatamicTags
{
    public function products()
    {
        $products = Product::whereAvailable(true)->get();

        if ($products->count() === 0) {
            return null;
        }

        // TODO: Can be removed?
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
                'stock'           => $product->stock,
                'stock_unlimited' => $product->stock_unlimited,
            ];

        });

         return $products;
    }

    public function paymentProcessUrl() {
        return route('butik.payment.process');
    }

    public function currencySymbol()
    {
        return config('butik.currency_symbol');
    }

    public function country()
    {
        return config('butik.country');
    }

    public function overview()
    {
        return config('butik.route_shop-prefix');
    }
}
