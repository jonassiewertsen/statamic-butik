<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ShopController extends WebController
{
    public function index()
    {
        return view(config('butik.template_product-index'));
    }

    public function show(Product $product)
    {
        if (! $product->available) {
            return redirect()->route('butik.shop');
        }

        return view(config('butik.template_product-show'), compact('product'));
    }
}
