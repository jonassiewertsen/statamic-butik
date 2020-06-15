<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class ShippingAmount
{
    use MoneyTrait;

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
    public int    $total;

    public function __construct(ShippingProfile $profile, int $total)
    {
        $this->profileTitle = $profile->title;
        $this->profileSlug  = $profile->slug;
        $this->total        = $total;
        $this->totalHuman   = $this->makeAmountHuman($total);
    }
}
