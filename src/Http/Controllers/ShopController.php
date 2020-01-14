<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\View\View;

class ShopController extends Controller
{
    public function index() {
        return (new \Statamic\View\View())
            ->layout('statamic-butik::web.layouts.shop')
            ->template('statamic-butik::web.shop.index')
            ->with(['title' => 'Overview']);
    }

    public function show(Product $product) {
        return (new \Statamic\View\View())
                ->template('statamic-butik::web.shop.show')
                ->with($product->toArray());
    }
}
