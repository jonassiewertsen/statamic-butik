<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use PHPUnit\Framework\Constraint\Count;

class ShippingZone extends ButikModel
{
    protected $table        = 'butik_shipping_zones';

    protected $guarded = [];

    /**
     * A shipping zone belongs to a shippin profile
     */
    public function profile()
    {
        return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug');
    }

    /**
     * A shipping zone belongs to many countries
     */
    public function countries()
    {
        return $this->belongsToMany(
            Country::class,
            'butik_country_shipping_zone',
            'shipping_zone_id',
            'country_slug',
        );
    }

    /**
     * Add a country to a shipping zone
     */
    public function addCountry($country)
    {
        $this->countries()->attach($country);
    }

    /**
     * Update
     */
    public function updateCountries(array $countries)
    {
        $this->countries()->sync($countries);
    }

    /**
     * Remove a country from a shipping zone
     */
    public function removeCountry($country)
    {
        $this->countries()->detach($country);
    }

    /**
     * A shipping zone belongs to many rates
     */
    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }
}
