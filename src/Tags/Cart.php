<?php

namespace Jonassiewertsen\StatamicButik\Tags;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;

class Cart extends \Statamic\Tags\Tags
{
    /**
     * Using {{ cart:items }} or {{ bag:items }} is basically
     * the same. Use whatever you prefer personally.
     */
    protected static $aliases = ['bag'];

    /**
     * {{ cart }}.
     *
     * Will return all items from the bag / shopping cart
     * Equivalent to {{ cart:items }}
     */
    public function index()
    {
        return $this->items();
    }

    /**
     * {{ cart:items }}.
     *
     * Will return all items from the cart / shopping cart
     * Equivalent to {{ cart }}
     */
    public function items()
    {
        /**
         * Antlers can't handle objects and collections very well.
         * To make them play nice together, we will return an
         * array with all needed informations for the
         * checkout process.
         */
        return ShoppingCart::get()->map(function ($item) {
            return [
                'available'       => $item->available,
                'sellable'        => $item->sellable,
                'available_stock' => $item->availableStock,
                'slug'            => $item->slug,
                'images'          => $item->images,
                'name'            => $item->name,
                'description'     => $item->description,
                'single_price'    => $item->singlePrice(),
                'total_price'     => $item->totalPrice(),
                'quantity'        => $item->getQuantity(),
            ];
        });
    }

    /**
     * {{ cart:total_items }}.
     *
     * Will return the total count of the items in your cart
     */
    public function totalItems()
    {
        return ShoppingCart::totalItems();
    }

    /**
     * {{ cart:total_shipping }}.
     *
     * Will return the total shipping costs
     */
    public function totalShipping()
    {
        return ShoppingCart::totalShipping();
    }

    /**
     * {{ cart:total_price }}.
     *
     * Will return the total price for the complete shopping cart
     */
    public function totalPrice()
    {
        return ShoppingCart::totalPrice();
    }

    /**
     * {{ cart:total_taxes }}.
     *
     * Will return the total price for the complete shopping cart
     */
    public function totalTaxes()
    {
        return ShoppingCart::totalTaxes();
    }
}
