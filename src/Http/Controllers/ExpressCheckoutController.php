<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class ExpressCheckoutController extends Controller
{
    public function delivery(Product $product) {
       return (new \Statamic\View\View())
           ->template('statamic-butik::web.checkout.express.delivery')
           ->with($product->toArray());
    }
}

//return (new \Statamic\View\View())
//    ->template('statamic-butik::web.shop.show')
