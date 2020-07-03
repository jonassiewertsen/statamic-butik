<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Http\Traits\ProductUrlTrait;

class Variant extends ButikModel
{
    protected $table = 'butik_variants';

    protected $casts = [
        'available'       => 'boolean',
        'inherit_stock'   => 'boolean',
        'inherit_price'   => 'boolean',
        'price'           => 'integer',
        'stock'           => 'integer',
        'stock_unlimited' => 'boolean',
    ];

    protected $guarded = [];

}
