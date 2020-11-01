<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

class ShippingByPrice extends ShippingType
{
    /**
     * The shipping costs are equal to the shipping price
     * of the selected shipping rate.
     */
    public function shippingCosts(): string
    {
        return $this->rate->price;
    }
}
