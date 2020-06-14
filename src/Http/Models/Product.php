<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;

class Product extends ButikModel
{
    use ProductUrlTrait;

    public    $incrementing = false;
    protected $table        = 'butik_products';
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'available'       => 'boolean',
        'base_price'      => 'integer',
        'stock'           => 'integer',
        'description'     => 'array',
        'images'          => 'array',
        'stock_unlimited' => 'boolean',
    ];

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A Product has taxes
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id', 'slug');
    }

        /**
         * A Product has a shipping relation
         */
        public function shippingProfile() {
            return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug', 'slug');
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
     * Will return the shipping price
     */
    public function getTaxPercentageAttribute()
    {
        return $this->tax->percentage;
    }

    public function getTaxAmountAttribute()
    {
        $tax = $data = str_replace(',', '.', $this->tax->percentage);

        $divisor = $tax + 100;
        $price   = $this->getOriginal('price');

        $totalPriceWithoutTax = $price / $divisor * 100;
        $tax                  = $price - $totalPriceWithoutTax;
        return $this->makeAmountHuman($tax);
    }

    /**
     * Return the price with currency appended
     */
    public function getSoldOutAttribute()
    {
        if ($this->stock_unlimited) {
            return false;
        }
        return $this->stock == 0;
    }

    /**
     * Return the price with currency appended
     */
    public function getCurrencyAttribute()
    {
        return config('butik.currency_symbol');
    }

    /**
     * The route to the base shop
     */
    private function shopRoute()
    {
        return config('butik.route_shop-prefix');
    }
}
