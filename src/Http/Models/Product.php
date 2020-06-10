<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;

class Product extends ButikModel
{
    use ProductUrlTrait;

    protected $table        = 'butik_products';
    public    $incrementing = false;
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
    public function tax() {
        return $this->belongsTo(Tax::class, 'tax_id', 'slug');
    }

    // TODO: Redefine the shipping relation
    //    /**
    //     * A Product has a shipping relation
    //     */
    //    public function shipping() {
    //        return $this->belongsTo(Shipping::class, 'shipping_id', 'slug');
    //    }

    /**
     * Will return the shipping price for this item
     */
    public function getTotalPriceAttribute()
    {
        $amount = $this->getOriginal('base_price') + $this->shipping->getOriginal('price');
        return $this->makeAmountHuman($amount);
    }

    /**
     * Will return the base price for this item
     */
    public function getBasePriceAttribute($value)
    {
        return $this->makeAmountHuman($value);
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setBasePriceAttribute($value)
    {
        $this->attributes['base_price'] = $this->makeAmountSaveable($value);
    }

    /**
     * Will return the shipping price
     */
    public function getShippingAmountAttribute($value)
    {
        return $this->shipping->price;
    }

    /**
     * Will return the shipping price
     */
    public function getTaxPercentageAttribute()
    {
        return $this->tax->percentage;
    }

    public function getTaxAmountAttribute() {
        $tax = $data = str_replace(',', '.', $this->tax->percentage);

        $divisor            = $tax + 100;
        $base_price         = $this->getOriginal('base_price');
        $shipping_amount    = $this->shipping->getOriginal('price');
        $total_amount       = $base_price + $shipping_amount;

        $totalPriceWithoutTax = $total_amount / $divisor * 100;
        $tax = $total_amount - $totalPriceWithoutTax;
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
    private function shopRoute() {
        return config('butik.route_shop-prefix');
    }
}
