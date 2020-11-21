<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

abstract class ShippingType implements ShippingTypeInterface
{
    use MoneyTrait;

    /**
     * The name of this shipping type, how we want to call it in the cp.
     */
    public string $name;

    /**
     * The detected shipping zone we want to calculate from.
     */
    public ShippingZone $zone;

    /**
     * The detected shipping rate.
     */
    public ShippingRate $rate;

    /**
     * All items from the shopping bag.
     */
    public Collection $items;

    /**
     * The total amount of items belonging to this shipping type.
     */
    public int $itemCount;

    /**
     * The combined value for all shipping items, which will
     * be used to calculate the shipping rate.
     */
    public int $summedItemValue;

    /**
     * The total amount we did calculate for this shipping type.
     */
    public int $total;

    public function __construct()
    {
        $this->name = $this->name();
    }

    public function set(Collection $items, ShippingZone $zone): void
    {
        $this->items = $items;
        $this->zone = $zone;

        $this->calculateSummedItemValue();
        $this->calculateTotalItemCount();
        $this->detectShippingRate($this->zone);
    }

    /**
     * We will fetch the name directly from the translation file. In case you want to use
     * another methods to define the name, feel free to overwrite this method for
     * your own shipping type.
     */
    protected function name(): string
    {
        $className = Str::snake(class_basename($this));
        $key = 'butik::cp.'.$className;

        return __($key);
    }

    /**
     * Calculate the total item values, so we can detect the correct
     * Shipping Rates later.
     */
    protected function calculateSummedItemValue(): void
    {
        $this->summedItemValue = 0;

        $this->items->each(function ($item) {
            $this->summedItemValue += $this->makeAmountSaveable($item->totalPrice());
        });
    }

    protected function calculateTotalItemCount(): void
    {
        $this->itemCount = 0;

        $this->items->each(function ($item) {
            $this->itemCount += $item->getQuantity();
        });
    }

    /**
     * Which shipping rate is the correct one for our
     * summed total values of all items?
     */
    protected function detectShippingRate($zone): void
    {
        // As the first step, we will only keep rates, where
        // the total item value is bigger or equal
        // as the minimum value of the shipping rate.
        $rates = $zone->rates->filter(function ($zone) {
            return $this->summedItemValue >= $this->convertIntoCents($zone->minimum);
        });

        // Making sure to select the correct rate, we
        // will sort them and select the first one.
        $this->rate = $rates->sortByDesc('minimum')->first();
    }

    public function calculate(): ShippingAmount
    {
        return new ShippingAmount(
            $this->shippingCosts(),
            $this->zone->profile,
            $this->rate,
            $this->zone->tax,
        );
    }

    /**
     * Converts a value into cents.
     */
    protected function convertIntoCents($value): int
    {
        return $value * 100;
    }

    abstract public function shippingCosts(): string;
}
