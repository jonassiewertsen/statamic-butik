<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;

class CartController extends WebController
{
    public function index() {
        return view(config('butik.template_cart'));
    }
}
