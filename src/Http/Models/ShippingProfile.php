<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class ShippingProfile extends ButikModel
{
    public    $incrementing = false;
    protected $table = 'butik_shipping_profiles';
    protected $primaryKey = 'slug';
    protected $keyType = 'string';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

//    protected $with = [''];

    public function zones()
    {
        return $this->hasMany(ShippingZone::class, 'shipping_profile_slug');
    }

    public function whereZoneFrom($countryCode): ?ShippingZone
    {
        return $this->zones()
            ->has('rates')
            ->where('countries', 'LIKE', "%\"$countryCode\"%")
            ->first();
    }

    public function getCountriesAttribute(): ?array
    {
        $shippingZones = $this->zones();
        $countries = collect();

        $shippingZones->each(function ($zone) use ($countries) {
            $countries->push($zone->countries->toArray());
        });

        return $countries->flatten()->toArray();
    }
}
