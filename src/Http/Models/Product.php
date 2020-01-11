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

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function getbasePriceAttribute($value) {
        $value = $value / 100;
        return number_format($value , 2, config('statamic-butik.currency.delimiter'), '');
    }

    public function getbasePriceWithCurrencySymbolAttribute($value) {
        return $this->base_price .' '.config('statamic-butik.currency.symbol');
    }
}
