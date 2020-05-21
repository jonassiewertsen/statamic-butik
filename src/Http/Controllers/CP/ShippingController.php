<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;

class ShippingController extends CpController
{
    public function index()
    {
//        $this->authorize('index', Shipping::class);

        return view('butik::cp.shipping.index');
    }
}
