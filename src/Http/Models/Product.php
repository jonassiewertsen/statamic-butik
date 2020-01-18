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
     * Mutating from a whole number into the correct amount
     */
    public function getBasePriceAttribute($value)
    {
        $value = floatval($value) / 100;

        return number_format($value, 2, config('statamic-butik.currency.delimiter'), '');
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setBasePriceAttribute($value)
    {
        // Converting string to integer and removing decimals
        $this->attributes['base_price'] = number_format(floatval($value) * 100, 0, '', '');
    }

    /**
     * Return the price with currency appended
     */
    public function getBasePriceWithCurrencySymbolAttribute($value)
    {
        return $this->base_price.' '.config('statamic-butik.currency.symbol');
    }

    /**
     * The route to the base shop
     */
    private function shopRoute() {
        return config('statamic-butik.uri.shop');
    }
}
