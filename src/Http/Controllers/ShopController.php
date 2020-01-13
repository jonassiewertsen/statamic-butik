<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\View\View;

class ShopController extends Controller
{
    public function index() {
        return view('statamic-butik::web.shop.index');
    }

    public function show(Product $product) {
        return (new \Statamic\View\View())
                ->template('statamic-butik::web.shop.show')
                ->with($product->toArray());
    }
}
