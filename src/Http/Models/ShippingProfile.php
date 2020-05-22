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

    public function zones() {
        return $this->hasMany(ShippingZone::class, 'shipping_profile_slug');
    }
}
