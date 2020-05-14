<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class ShippingType extends ButikModel
{
    protected $table        = 'butik_shipping_types';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

//    /**
//     * A country has a edit url
//     */
//    public function getEditUrlAttribute()
//    {
//        $cp_route = config('statamic.cp.route');
//
//        return "/{$cp_route}/butik/settings/countries/{$this->slug}/edit";
//    }
}
