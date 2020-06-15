<?php


namespace Jonassiewertsen\StatamicButik\Shipping;


use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

abstract class ShippingType implements ShippingTypeInterface
{
    public ShippingZone $zone;

    public Collection $items;

    public int $total;

    public function __construct(Collection $items, ShippingZone $zone)
    {
        $this->zone  = $zone;
        $this->items = $items;
    }
}
