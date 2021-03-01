<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Blueprints\OrderBlueprint;
use Jonassiewertsen\StatamicButik\Facades\Price;
use Statamic\Fields\Blueprint;

class Order extends ButikModel
{
    protected $table = 'butik_orders';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $casts = [
        'products'      => 'array',
        'paid_at'       => 'datetime',
        'failed_at'     => 'datetime',
        'canceled_at'   => 'datetime',
        'shipped_at'    => 'datetime',
        'completed_at'  => 'datetime',
    ];

    protected $guarded = [];

    public function blueprint(): Blueprint
    {
        return call_user_func(new OrderBlueprint());
    }

    public function getShowUrlAttribute()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/orders/{$this->id}";
    }

    /**
     * Will return the base price for this item.
     */
    public function getTotalAmountAttribute($value)
    {
        return Price::of($value)->amount();
    }

    /**
     * Mutating from a the correct amount into a integer without commas.
     */
    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = Price::of($value)->cents();
    }

    /**
     * Will return the base price for this item.
     */
    public function getCustomerAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Mutating from a the correct amount into a integer without commas.
     */
    public function setCustomerAttribute($value)
    {
        $this->attributes['customer'] = json_encode($value);
    }

    /**
     * Will return the items as an object.
     */
    public function getItemsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Will return the shippings as an object.
     */
    public function getShippingsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Mutating from a the correct amount into a integer without commas.
     */
    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = json_encode($value);
    }
}
