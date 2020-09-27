<?php

namespace Jonassiewertsen\StatamicButik\Http\Traits;

use Jonassiewertsen\StatamicButik\Checkout\Cart;

trait MapCartItems {
    /**
     * Antlers can't handle objects and collections very well.
     * To make them play nice together, we will return an
     * array with all needed informations for the
     * checkout process.
     */
    private function mappedCartItems()
    {
        return Cart::get()->map(function ($item) {
            return [
                'available'      => $item->available,
                'sellable'       => $item->sellable,
                'availableStock' => $item->availableStock,
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
}
