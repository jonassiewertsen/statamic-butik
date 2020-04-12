<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class CartController extends WebController
{
    protected ?Cart $cart;

    public function index() {
        $this->cart = (new Cart)->get();

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_cart'))
            ->template(config('butik.template_cart-overview'))
            ->with([
                'title' => __('butik::cart.singular'),
                'items'  => $this->cart->items->toArray()
            ]);
    }

    public function add(Product $product) {
        $this->cart = (new Cart)->get();
        $this->cart->add($product);
        return back();
    }
}
