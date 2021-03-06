<?php

namespace Jonassiewertsen\Butik\Shipping;

use Jonassiewertsen\Butik\Facades\Number;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\Tax;

class ShippingAmount
{
    /**
     * The Shipping profile title of this shipping amount.
     */
    public string $profileTitle;

    /**
     * The name of the choosen rate title.
     */
    public string $rateTitle;

    /**
     * The Shipping profile slug of this shipping amount.
     */
    public string $profileSlug;

    /**
     * The total amount for all items belonging to the named shipping profile.
     */
    public string $total;

    /**
     * The tax amount for all items belonging for the used shipping.
     */
    public float $taxRate;
    public string $taxAmount;

    public function __construct(string $total, ShippingProfile $profile, ShippingRate $rate, ?Tax $tax)
    {
        $this->profileTitle = $profile->title;
        $this->profileSlug = $profile->slug;
        $this->rateTitle = $rate->title;
        $this->total = $total;
        $this->taxRate = $this->taxRate($tax);
        $this->taxAmount = $this->calculateTaxAmount($tax, $total);
    }

    private function calculateTaxAmount(?Tax $tax, string $amount): string
    {
        $taxRate = $this->taxPercentage($tax);

        return Price::of($amount)
            ->multiply($taxRate / 100)
            ->get();
    }

    private function taxRate(?Tax $tax): float
    {
        return Number::of($this->taxPercentage($tax))->decimal();
    }

    private function taxPercentage(?Tax $tax): int
    {
        return $tax ? $tax->percentage : 0;
    }
}
