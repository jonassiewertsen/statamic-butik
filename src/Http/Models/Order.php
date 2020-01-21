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
    protected $guarded = [];
}
