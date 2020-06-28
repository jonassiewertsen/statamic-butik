<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class ShippingRate extends ButikModel
{
    use MoneyTrait;

    protected $table = 'butik_shipping_rates';

    protected $casts = [
        'minimum' => 'integer',
        'price'   => 'integer',
    ];

    protected $guarded = [];

    /**
     * Will return the base price for this item
     */
    public function getPriceAttribute($value)
    {
        return $this->makeAmountHuman($value);
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $this->makeAmountSaveable($value);
    }
}
