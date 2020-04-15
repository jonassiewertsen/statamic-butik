<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class CartController extends WebController
{
    public function index() {
        return view(config('butik.template_cart-index'));
    }
}
