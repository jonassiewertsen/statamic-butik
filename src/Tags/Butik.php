<?php

namespace Jonassiewertsen\Butik\Tags;

use Jonassiewertsen\Butik\Facades\Product;

class Butik extends \Statamic\Tags\Tags
{
    /**
     * {{ butik:shop }}.
     *
     * Will return the shop overview route
     */
//    public function shop()
//    {
//        return $this->route('butik.shop');
//    }

    /**
     * {{ butik:shop }}.
     *
     * Will return the shop overview route
     */
    public function payment()
    {
        return $this->route('butik.checkout.payment');
    }

    /**
     * {{ butik:cart }}.
     *
     * Will return the shop overview route
     */
    public function cart()
    {
        return $this->route('butik.cart');
    }

    /**
     * {{ butik:bag }}.
     *
     * Will return the shop overview route
     */
    public function bag()
    {
        return $this->cart();
    }
    
    public function products()
    {
        return Product::all();
    }

    private function route(string $routeName): string
    {
        return route($routeName, [], false);
    }
}
