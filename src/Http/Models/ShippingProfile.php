<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Support\Facades\DB;

class ShippingProfile extends ButikModel
{
    public    $incrementing = false;
    protected $table        = 'butik_shipping_profiles';
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

//    protected $with = [''];

    public function zones()
    {
        return $this->hasMany(ShippingZone::class, 'shipping_profile_slug');
    }

    public function whereZoneFrom($country_code): ?ShippingZone
    {
        return $this->zones()
                    ->has('rates')
                    ->where('countries', 'LIKE', "%\"$country_code\"%")
                    ->first();
    }
}
