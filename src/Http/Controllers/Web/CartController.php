<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\Web;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class CartController extends WebController
{
    protected ?Cart $cart;

    public function __construct() {
        if (Session::has('butik.cart')) {
            $this->cart = Session::get('butik.cart');
        } else {
            $this->cart = new Cart();
        }
    }

    public function index() {

        return (new \Statamic\View\View())
            ->layout(config('butik.layout_cart'))
            ->template(config('butik.template_cart-overview'))
            ->with([
                'title' => __('butik::cart.singular'),
                'cart'  => $this->cart
            ]);
    }

    public function add(Product $product) {
        $this->cart->add($product);

        return back();
    }
}
