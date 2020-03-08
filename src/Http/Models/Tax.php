<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Tax extends ButikModel
{
    protected $table        = 'butik_taxes';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'percentage' => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products() {
        return $this->hasMany(Product::class, 'tax_id');
    }

    public function editUrl()
    {
        return cp_route('butik.taxes.edit', $this);
    }

    public function getPercentageAttribute($value)
    {
        return $this->makeAmountHuman($value);
    }

    public function setPercentageAttribute($value)
    {
        $this->attributes['percentage'] = $this->makeAmountSaveable($value);
    }
}
