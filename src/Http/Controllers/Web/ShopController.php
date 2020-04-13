<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ShopController extends WebController
{
    public function index() {
//        return (new \Statamic\View\View())
//            ->layout(config('butik.layout_product-overview'))
//            ->template(config('butik.template_product-overview'))
//            ->with(['title' => 'Overview']);

        return view('butik::web.shop.index');
    }

    public function show(Product $product)
    {
        if (! $product->available) {
            return redirect()->route('butik.shop');
        }

        $product = $this->addingProductRoutes($product);

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_product-show'))
            ->template(config('butik.template_product-show'))
            ->with($product);
    }
}
