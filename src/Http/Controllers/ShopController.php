<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

class ShopController extends Controller
{
    public function index() {
        return view('statamic-butik::web.shop.index');
    }
}
