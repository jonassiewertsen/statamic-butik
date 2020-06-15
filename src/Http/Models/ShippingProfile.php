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

//    protected $with = [''];

    public function zones()
    {
        return $this->hasMany(ShippingZone::class, 'shipping_profile_slug');
    }

    public function whereZoneFrom(Country $country): ?ShippingZone
    {
        return $this->zones()
                    ->leftJoin('butik_country_shipping_zone', 'butik_shipping_zones.id', '=', 'butik_country_shipping_zone.shipping_zone_id')
                    ->select('id', 'title', 'slug', 'type', 'shipping_zone_id', 'country_slug')
                    ->where('country_slug', $country->slug)
                    ->first();
    }
}
