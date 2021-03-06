<?php

namespace Jonassiewertsen\Butik\Shipping;

use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;

interface ShippingTypeInterface
{
    public function calculate(): ShippingAmount;

    public function set(Collection $items, ShippingZone $zone): void;
}
