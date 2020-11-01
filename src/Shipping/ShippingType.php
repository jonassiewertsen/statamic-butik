<?php


namespace Jonassiewertsen\StatamicButik\Shipping;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

abstract class ShippingType implements ShippingTypeInterface
{
    /**
     * The name of this shipping type, how we want to call it in the cp.
     */
    public string $name;

    /**
     * The detected shipping zone we want to calculate from.
     */
    public ShippingZone $zone;

    /**
     * All items from the shopping bag.
     */
    public Collection $items;

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
        $this->zone  = $zone;
    }

    /**
     * We will fetch the name directly from the translation file. In case you want to use
     * another methods to define the name, feel free to overwrite this method for
     * your own shipping type.
     */
    protected function name(): string
    {
        $className = Str::snake(class_basename($this));
        $key       = 'butik::cp.' . $className;
        return __($key);
    }


    /**
     * The shipping costs are equal to the shipping price
     * of the selected shipping rate.
     */
    protected function shippingCosts(): string
    {
        return $this->rate->price;
    }

    /**
     * Converts a value into cents
     */
    protected function convertIntoCents($value): int
    {
        return $value * 100;
    }
}
