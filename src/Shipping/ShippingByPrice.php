<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class ShippingByPrice extends ShippingType
{
    use MoneyTrait;

    public int $totalItemValue;

    public ShippingZone $zone;

    public ShippingRate $rate;

    public function __construct($profile, $items, $country)
    {
        parent::__construct($profile, $items, $country);
        $this->totalItemValue = 0;
    }

    public function calculate()
    {
        $this->filterItems();
        $this->calculateSummedItemValue();
        $this->detectShippingZone();
        $this->detectShippingRate();

        return $this->shippingCosts();
    }

    /**
     * Filter items, so that only items belonging to the selected shipping
     * profile will be used to calculate the shipping costs.
     */
    private function filterItems(): void
    {
        $this->items = $this->items->filter(function ($item) {
            return $item->shippingProfile->slug === $this->profile->slug;
        });
    }

    /**
     * We need to calculate the item values, so we can detect the correct
     * Shipping Rates later. This step is dedicated to the shipping
     * type calculated via the bag price.
     */
    private function calculateSummedItemValue(): void
    {
        $this->items->each(function ($item) {
            $this->totalItemValue += $this->makeAmountSaveable($item->totalPrice());
        });
    }

    /**
     * The detected shipping zone, belonging to our selected country.
     */
    private function detectShippingZone(): void
    {
        $this->zone = $this->profile->whereZoneFrom($this->country);
    }

    /**
     * Which shipping rate is the correct one for our
     * summed total values of all items?
     */
    private function detectShippingRate(): void
    {
        // As the first step, we will on keep the rates where,
        // where the total item value is bigger or equal
        // as the minimum value of the shipping rate.
        $rates = $this->zone->rates->filter(function ($zone) {
            return $this->totalItemValue >= $zone->minimum;
        });

        // Making sure to select the correct rate, we
        // will sort them and select the first one.
        $this->rate = $rates->sortBy('minimum')->first();
    }

    /**
     * The shipping costs are equal to the shipping price
     * of the selected shipping rate.
     */
    private function shippingCosts(): int
    {
        return $this->rate->price;
    }
}
