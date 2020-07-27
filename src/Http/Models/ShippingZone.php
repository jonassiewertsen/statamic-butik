<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\Intl\Countries;

class ShippingZone extends ButikModel
{
    protected $table = 'butik_shipping_zones';

    protected $guarded = [];

    protected $casts = [
        'countries' => 'collection'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = ['countries_display'];

    public function getCountriesDisplayAttribute()
    {
        return $this->countries->map(function($countryCode) {
            return Countries::getName($countryCode);
        });
    }

    public function setCountriesAttribute($value)
    {
        sort($value);
        $this->attributes['countries'] = json_encode($value);
    }

    /**
     * A shipping zone belongs to a shipping profile
     */
    public function profile()
    {
        return $this->belongsTo(ShippingProfile::class, 'shipping_profile_slug');
    }

    /**
     * A shipping zone belongs to many rates
     */
    public function rates()
    {
        return $this->hasMany(ShippingRate::class)
                    ->orderBy('minimum');
    }
}
