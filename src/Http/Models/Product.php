<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table        = 'products';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'description' => 'array',
        'images'      => 'array',
        'base_price'  => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function editUrl()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/products/{$this->slug}/edit";
    }

    public function showUrl()
    {
        $web_route = config('statamic-butik.uri.shop');

        return "{$web_route}/{$this->slug}";
    }

    public function expressDeliveryUrl()
    {
        $web_route = config('statamic-butik.uri.shop');
        $checkout = config('statamic-butik.uri.checkout.express.delivery');

        return "{$web_route}/{$checkout}/{$this->slug}";
    }

    public function expressPaymentUrl()
    {
        $web_route = config('statamic-butik.uri.shop');
        $checkout = config('statamic-butik.uri.checkout.express.payment');

        return "{$web_route}/{$checkout}/{$this->slug}";
    }

    public function expressReceiptUrl()
    {
        $web_route = config('statamic-butik.uri.shop');
        $checkout = config('statamic-butik.uri.checkout.express.receipt');

        return "{$web_route}/{$checkout}/{$this->slug}";
    }

    public function getBasePriceAttribute($value)
    {
        $value = floatval($value) / 100;

        return number_format($value, 2, config('statamic-butik.currency.delimiter'), '');
    }

    public function setBasePriceAttribute($value)
    {
        // Converting string to integer and removing decimals
        $this->attributes['base_price'] = number_format(floatval($value) * 100, 0, '', '');
    }

    public function getBasePriceWithCurrencySymbolAttribute($value)
    {
        return $this->base_price.' '.config('statamic-butik.currency.symbol');
    }
}
