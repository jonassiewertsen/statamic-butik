<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Order extends ButikModel
{
    protected $table        = 'butik_orders';
    public    $incrementing = false;
    protected $primaryKey   = 'id';
    protected $keyType      = 'string';

    protected $casts = [
        'products'   => 'array',
        'paid_at'    => 'datetime',
        'shipped_at' => 'datetime',
    ];

    protected $appends = [
        'showUrl',
    ];

    protected $guarded = [];

    public function getShowUrlAttribute()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/orders/{$this->id}";
    }

    /**
     * Will return the base price for this item
     */
    public function getTotalAmountAttribute($value)
    {
        return $this->makeAmountHuman($value);
    }

    /**
     * Mutating from a the correct amount into a integer without commas
     */
    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = $this->makeAmountSaveable($value);
    }
}
