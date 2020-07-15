<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Products extends \Statamic\Tags\Tags
{
    /**
     * {{ products }}
     *
     * Will return all products as an array, so it can be easily rendered via antlers.
     */
    public function index() {
        return Product::all()->toArray();
    }
}
