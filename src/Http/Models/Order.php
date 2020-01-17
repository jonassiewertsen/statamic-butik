<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $casts = [
        'products'   => 'array',
        'paid_at'    => 'datetime',
        'shipped_at' => 'datetime',
    ];
    protected $guarded = [];
}
