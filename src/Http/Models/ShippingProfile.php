<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class ShippingProfile extends ButikModel
{
    protected $table        = 'butik_shipping_profiles';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

//    protected $with = [''];

    public function countries() {
        return $this->hasMany(Country::class, 'slug');
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
