<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Checkout\Cart;

class Bag extends \Statamic\Tags\Tags
{
    /**
     * {{ bag }}
     *
     * Will return all items from the bag / shopping cart
     * Equivalent to {{ bag:items }}
     */
    public function index()
    {
        return $this->items();
    }

    /**
     * {{ bag:items }}
     *
     * Will return all items from the bag / shopping cart
     * Equivalent to {{ bag }}
     */
    public function items()
    {
        return Cart::get();
    }

    /**
     * {{ bag:totaltems }}
     *
     * Will return the total count of the items in your bag
     */
    public function totalItems()
    {
        return Cart::totalItems();
    }

    /**
     * {{ bag:totalShipping }}
     *
     * Will return the total shipping costs
     */
    public function totalShipping()
    {
        return Cart::totalShipping();
    }

    /**
     * {{ bag:totalShipping }}
     *
     * Will return the total price for the complete shopping bag
     */
    public function totalPrice()
    {
        return Cart::totalPrice();
    }
}
