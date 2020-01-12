<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $incrementing = false;
    protected $primaryKey = 'slug';
    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'description' => 'array',
        'images'      => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
//    public function getbasePriceAttribute($value) {
//        $value = $value / 100;
//        return number_format($value , 2, config('statamic-butik.currency.delimiter'), '');
//    }

//    public function setbasePriceAttribute($value) {
//        $this->attributes['base_price'] = $value * 100;
//    }

    public function getbasePriceWithCurrencySymbolAttribute($value) {
        return $this->base_price .' '.config('statamic-butik.currency.symbol');
    }
}
