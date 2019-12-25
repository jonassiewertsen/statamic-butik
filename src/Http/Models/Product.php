<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
        'description' => 'array',
        'images'      => 'array',
    ];

    protected $guarded = [];
}
