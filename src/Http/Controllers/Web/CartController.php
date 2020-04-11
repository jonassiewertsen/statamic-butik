<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;

class CartController extends WebController
{
    public function index() {
        return (new \Statamic\View\View())
            ->layout(config('butik.layout_cart'))
            ->template(config('butik.template_cart-overview'))
            ->with(['title' => __('butik::cart.singular')]);
    }
}
