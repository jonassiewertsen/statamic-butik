<?php

namespace Jonassiewertsen\StatamicButik\Tags;

class Butik extends \Statamic\Tags\Tags
{
    /**
     * {{ butik:shop }}.
     *
     * Will return the shop overview route
     */
    public function shop()
    {
        return route('butik.shop');
    }

    /**
     * {{ butik:bag }}.
     *
     * Will return the shop overview route
     */
    public function bag()
    {
        return route('butik.cart');
    }
}
