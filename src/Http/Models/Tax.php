<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';

    protected $casts = [
        'percentage' => 'integer',
    ];
    protected $guarded = [];
}
