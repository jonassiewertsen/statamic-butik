<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class Variant extends ButikModel
{
    use MoneyTrait;

    protected $table = 'butik_variants';

    protected $casts = [
        'available'       => 'boolean',
        'inherit_stock'   => 'boolean',
        'inherit_price'   => 'boolean',
        'price'           => 'integer',
        'stock'           => 'integer',
        'stock_unlimited' => 'boolean',
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
