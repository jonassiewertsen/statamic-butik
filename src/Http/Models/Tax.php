<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Facades\Price;

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
        // A Tax value without decimals, will be returned as integer
        if ($value % 100 === 0) {
            return $value / 100;
        }

        return Price::of($value)->get();
    }

    public function setPercentageAttribute($value)
    {
        $this->attributes['percentage'] = Price::of($value)->cents();
    }
}
