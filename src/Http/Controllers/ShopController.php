<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\View\View;

class ShopController extends Controller
{
    public function index() {
        $layout = config('statamic-butik.frontend.layout.overview', 'statamic-butik::web.layouts.shop');
        $template = config('statamic-butik.layout.overview', 'statamic-butik::web.shop.overview');

        return (new \Statamic\View\View())
            ->layout($layout)
            ->template($template)
            ->with(['title' => 'Overview']);
    }

    public function show(Product $product) {
        $layout = config('statamic-butik.frontend.layout.show', 'statamic-butik::web.layouts.shop');
        $template = config('statamic-butik.frontend.template.show', 'statamic-butik::web.shop.show');

        return (new \Statamic\View\View())
            ->layout($layout)
            ->template($template)
            ->with($product->toArray());
    }
}
