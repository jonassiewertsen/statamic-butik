<?php


namespace Jonassiewertsen\StatamicButik\Shipping;


use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

abstract class ShippingType implements ShippingTypeInterface
{
    public ShippingProfile $profile;

    public Collection $items;

    public Country $country;

    public int $total;

    public function __construct(ShippingProfile $profile, Collection $items, Country $country)
    {
        $this->profile = $profile;
        $this->country = $country;
        $this->items = $items;
    }
}
