<?php

namespace Jonassiewertsen\Butik\Http\Models;

use Facades\Jonassiewertsen\Butik\Http\Models\Product;
use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Facades\Number;

class Tax extends ButikModel
{
    protected $table = 'butik_taxes';
    public $incrementing = false;
    protected $primaryKey = 'slug';
    protected $keyType = 'string';

    protected $casts = [
        'percentage' => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getProductsAttribute(): Collection
    {
        return Product::where('tax_id', $this->slug)->get();
    }

    public function editUrl()
    {
        return cp_route('butik.taxes.edit', $this);
    }

    public function getPercentageAttribute($value)
    {
        return Number::of($value)->decimal();
    }

    public function setPercentageAttribute($value)
    {
        $this->attributes['percentage'] = Number::of($value)->decimal();
    }
}
