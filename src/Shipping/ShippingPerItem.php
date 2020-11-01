<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

class ShippingPerItem extends ShippingType
{
    /**
     * The shipping costs are equal to the shipping price
     * of the selected shipping rate.
     */
    public function shippingCosts(): string
    {
        $price = $this->makeAmountSaveable($this->rate->price);

        return $this->makeAmountHuman($price * $this->itemCount);
    }
}
