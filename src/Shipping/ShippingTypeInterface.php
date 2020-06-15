<?php

namespace Jonassiewertsen\StatamicButik\Shipping;



interface ShippingTypeInterface
{
    public function calculate(): ShippingAmount;
}
