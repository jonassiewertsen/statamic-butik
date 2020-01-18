<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;

class Product extends Model
{
    use ProductUrlTrait;

    protected $table        = 'products';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'description' => 'array',
        'images'      => 'array',
        'base_price'  => 'integer',
    ];

    protected $appends = [
        'total_price',
        'tax_amount',
        'shipping_amount',
        'editUrl',
        'showUrl',
        'ExpressDeliveryUrl',
        'ExpressPaymentUrl',
        'ExpressReceiptUrl',
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

    /**
     * A Product has a shipping relation
     */
    public function shipping() {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'slug');
    }

    /**
     * Will return the shipping price for this item
     */
    public function getTotalPriceAttribute()
    {
        $amount = $this->getOriginal('base_price') + $this->getOriginal('shipping_amount');
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
     * Will return the shipping price
     */
    public function getShippingAmountAttribute()
    {
        return $this->makeAmountHuman($this->shipping->price);
    }

    public function getTaxAmountAttribute() {
        $divisor            = $this->tax->percentage + 100;
        $base_price         = $this->getOriginal('base_price');
        $shipping_amount    = $this->shipping->price;
        $total_amount       = $base_price + $shipping_amount;

        $totalPriceWithoutTax = $total_amount / $divisor * 100;
        return round($total_amount - $totalPriceWithoutTax, 2);
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setBasePriceAttribute($value)
    {
        $this->attributes['base_price'] = $this->makeAmountSaveable($value);
    }

    /**
     * Return the price with currency appended
     */
    public function getBasePriceWithCurrencySymbolAttribute($value)
    {
        return $this->base_price.' '.config('statamic-butik.currency.symbol');
    }

    public function makeAmountHuman($value)
    {
        $value = floatval($value) / 100;

        $delimiter = config('statamic-butik.currency.delimiter');
        return number_format($value, 2, $delimiter, '');
    }

    private function makeAmountSaveable($value)
    {
        return number_format(floatval($value) * 100, 0, '', '');
    }

    /**
     * The route to the base shop
     */
    private function shopRoute() {
        return config('statamic-butik.uri.shop');
    }
}
