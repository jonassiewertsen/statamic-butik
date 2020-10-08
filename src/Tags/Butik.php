<?php

namespace Jonassiewertsen\StatamicButik\Tags;

class Butik extends \Statamic\Tags\Tags
{
    /**
     * {{ butik:shop }}
     *
     * Will return the shop overview route
     */
    public function shop()
    {
        return route('butik.shop');
    }

    /**
     * {{ butik:shop }}
     *
     * Will return the shop overview route
     */
    public function payment()
    {
        return route('butik.checkout.payment');
    }

    /**
     * {{ butik:cart }}
     *
     * Will return the shop overview route
     */
    public function cart()
    {
        return route('butik.cart');
    }

    /**
     * {{ butik:bag }}
     *
     * Will return the shop overview route
     */
    public function bag()
    {
        return route('butik.cart');
    }
}
