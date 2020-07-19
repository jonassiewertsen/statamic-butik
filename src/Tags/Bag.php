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
        /**
         * Antlers can't handle objects and collections very well.
         * To make them play nice together, we will return an
         * array with all needed informations for the
         * checkout process.
         */
        return Cart::get()->map(function ($item) {
            return [
                'available'      => $item->available,
                'sellable'       => $item->sellable,
                'available_stock' => $item->availableStock,
                'slug'           => $item->slug,
                'images'         => $item->images,
                'name'           => $item->name,
                'description'    => $item->description,
                'single_price'   => $item->singlePrice(),
                'total_price'    => $item->totalPrice(),
                'quantity'       => $item->getQuantity(),
            ];
        });
    }

    /**
     * {{ bag:total_items }}
     *
     * Will return the total count of the items in your bag
     */
    public function totalItems()
    {
        return Cart::totalItems();
    }

    /**
     * {{ bag:total_shipping }}
     *
     * Will return the total shipping costs
     */
    public function totalShipping()
    {
        return Cart::totalShipping();
    }

    /**
     * {{ bag:total_price }}
     *
     * Will return the total price for the complete shopping bag
     */
    public function totalPrice()
    {
        return Cart::totalPrice();
    }
}
