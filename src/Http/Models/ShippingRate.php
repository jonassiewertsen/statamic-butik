<?php

namespace Jonassiewertsen\Butik\Http\Models;

use Jonassiewertsen\Butik\Facades\Price;

class ShippingRate extends ButikModel
{
    protected $table = 'butik_shipping_rates';

    protected $casts = [
        'minimum' => 'integer',
        'price'   => 'integer',
    ];

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Will return the base price for this item.
     */
    public function getPriceAttribute($value)
    {
        return Price::of($value)->get();
    }

    /**
     * Mutating from a the correct amount into a integer without commas.
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = Price::of($value)->cents();
    }
}
