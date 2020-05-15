<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class ShippingZone extends ButikModel
{
    protected $table        = 'butik_shipping_zones';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

    /**
     * A shipping zone belongs to a shippin profile
     */
    public function profile()
    {
        return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug');
    }

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
