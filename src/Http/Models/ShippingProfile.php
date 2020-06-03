<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class ShippingProfile extends ButikModel
{
    public    $incrementing = false;
    protected $table        = 'butik_shipping_profiles';
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

//    protected $with = [''];

    public function zones()
    {
        return $this->hasMany(ShippingZone::class, 'shipping_profile_slug');
    }
}
