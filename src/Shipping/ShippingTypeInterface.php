<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

interface ShippingTypeInterface
{
    public function calculate(): ShippingAmount;

    public function set(Collection $items, ShippingZone $zone): void;
}
