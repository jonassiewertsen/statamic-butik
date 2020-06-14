<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use PHPUnit\Framework\Constraint\Count;

class ShippingRate extends ButikModel
{
    protected $table = 'butik_shipping_rates';

    protected $casts = [
        'minimum' => 'integer',
        'price'   => 'integer',
    ];

    protected $guarded = [];
}
