<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Order extends ButikModel
{
    protected $table = 'butik_orders';

    protected $casts = [
        'products'   => 'array',
        'paid_at'    => 'datetime',
        'shipped_at' => 'datetime',
    ];
    protected $guarded = [];
}
