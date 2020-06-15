<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class ShippingByPrice extends ShippingType
{
    use MoneyTrait;

    public ShippingZone $zone;
    public ShippingRate $rate;
    public int          $totalItemValue;

    public function __construct($items, $zone)
    {
        parent::__construct($items, $zone);
        $this->totalItemValue = 0;
    }

    public function calculate(): ShippingAmount
    {
        $this->calculateSummedItemValue();
        $this->detectShippingRate($this->zone);

        return new ShippingAmount(
            $this->zone->profile,
            $this->shippingCosts(),
        );
    }

    /**
     * Which shipping rate is the correct one for our
     * summed total values of all items?
     */
    protected function detectShippingRate($zone): void
    {
        // As the first step, we will on keep the rates where,
        // where the total item value is bigger or equal
        // as the minimum value of the shipping rate.
        $rates = $zone->rates->filter(function ($zone) {
            return $this->totalItemValue >= $zone->minimum;
        });

        // Making sure to select the correct rate, we
        // will sort them and select the first one.
        $this->rate = $rates->sortByDesc('minimum')->first();
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
     * The shipping costs are equal to the shipping price
     * of the selected shipping rate.
     */
    private function shippingCosts(): int
    {
        return $this->rate->price;
    }
}
