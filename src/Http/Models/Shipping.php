<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Shipping extends ButikModel
{
    protected $table = 'butik_shippings';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'price' => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    /**
     * Return the price with currency appended
     */
    public function getPriceWithCurrencySymbolAttribute($value)
    {
        return config('butik.currency_symbol').' '.$this->price;
    }

    public function products() {
        return $this->hasMany(Product::class, 'shipping_id');
    }

    public function editUrl()
    {
        return cp_route('butik.shippings.edit', $this);
    }
}
