<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class ShippingAmount
{
    /**
     * The Shipping profile title of this shipping amount
     */
    public string $profileTitle;

    /**
     * The Shipping profile slug of this shipping amount
     */
    public string $profileSlug;

    /**
     * The total amount for all items belonging to the named shipping profile
     */
    public string    $total;

    public function __construct(string $total, ShippingProfile $profile, ShippingRate $rate)
    {
        $this->profileTitle = $profile->title;
        $this->profileSlug  = $profile->slug;
        $this->rateTitle    = $rate->title;
        $this->total        = $total;
    }
}
