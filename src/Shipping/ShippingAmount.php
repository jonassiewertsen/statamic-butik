<?php


namespace Jonassiewertsen\StatamicButik\Shipping;


use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingAmount
{
    public string $profileTitle;
    public string $profileSlug;
    public int    $total;

    public function __construct(ShippingProfile $profile, int $total)
    {
        $this->profileTitle = $profile->title;
        $this->profileSlug  = $profile->slug;
        $this->total        = $total;
    }
}
