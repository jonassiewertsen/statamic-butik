<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ShopController extends Controller
{
    public function index() {
        return view('statamic-butik::web.shop.index');
    }

    public function show(Product $product) {
        return view('statamic-butik::web.shop.show', compact($product));
    }
}
