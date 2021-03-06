<?php

namespace Jonassiewertsen\Butik\Tags;

use Facades\Jonassiewertsen\Butik\Http\Models\Product;

class Products extends \Statamic\Tags\Tags
{
    /**
     * {{ products }}.
     *
     * Will return all products as an array, so it can be easily rendered via antlers.
     */
    public function index()
    {
        return Product::all()->map(function ($product) {
            return (array) $product;
        });
    }
}
