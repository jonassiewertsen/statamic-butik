<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Jonassiewertsen\StatamicButik\Facades\Price;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;

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

        // Format values
        $amount = Price::of($amount)->cents();
        $taxRate = str_replace(',', '.', $taxRate);
        // Calculate tax amount
        $taxAmount = $amount * ($taxRate / (100 + $taxRate));

        return Price::of(round($taxAmount, 2))->delimiter('.')->get();
    }

    private function taxRate(?Tax $tax): string
    {
        return (string) number_format($this->taxPercentage($tax), 2);
    }

    private function taxPercentage(?Tax $tax): int
    {
        return $tax ? $tax->percentage : 0;
    }
}
