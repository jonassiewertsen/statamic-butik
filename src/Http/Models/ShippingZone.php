<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Jonassiewertsen\StatamicButik\Shipping\Country;

class ShippingZone extends ButikModel
{
    protected $table = 'butik_shipping_zones';

    protected $guarded = [];

    protected $casts = [
        'countries' => 'collection',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['country_names'];

    public function getCountryNamesAttribute()
    {
        if (! $this->countries) {
            return null;
        }

        return $this->countries->map(function ($countryCode) {
            return Country::getName($countryCode);
        });
    }

    public function setCountriesAttribute($value)
    {
        sort($value);
        $this->attributes['countries'] = json_encode($value);
    }

    /**
     * A shipping zone belongs to a shipping profile.
     */
    public function profile()
    {
        return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug');
    }

    /**
     * A shipping zone belongs to many rates.
     */
    public function rates()
    {
        return $this->hasMany(ShippingRate::class)->orderBy('minimum');
    }

    /**
     * A shipping zone can have taxes.
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_slug', 'slug');
    }
}
