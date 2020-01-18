<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\View\View;

class ShopController extends WebController
{
    public function index() {
        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.overview'))
            ->template(config('statamic-butik.frontend.template.overview'))
            ->with(['title' => 'Overview']);
    }

    public function show(Product $product)
    {
        $product = $this->addingProductRoutes($product);

        return (new \Statamic\View\View())
            ->layout(config('statamic-butik.frontend.layout.show'))
            ->template(config('statamic-butik.frontend.template.show'))
            ->with($product);
    }
}
