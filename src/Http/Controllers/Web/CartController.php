<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Statamic\View\View as StatamicView;

class CartController extends WebController
{
    public function index()
    {
        return (new StatamicView())
            ->template(config('butik.template_cart'))
            ->layout(config('butik.layout_cart'));
    }
}
