<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Country extends ButikModel
{
    protected $table        = 'butik_countries';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

    /**
     * A country has a edit url
     */
    public function getEditUrlAttribute()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/settings/countries/{$this->slug}/edit";
    }

    /**
     * Does a country exist in the passed shipping zone?
     */
    public function inCurrentZone(ShippingZone $shippingZone): bool {
        return $shippingZone->countries->contains($this->slug);
    }

    /**
     * Can a country be attached to this shipping zone?
     *
     * It will return true, if the country does not exist in
     * one of the existing shipping zones, related
     * to the shipping profile.
     */
    public function attachableTo(ShippingProfile $shippingProfile): bool {
        foreach ($shippingProfile->zones as $zone) {
            if ($zone->countries->contains('slug', $this->slug)) {
                return false; // Ups. This country already attached to this shipping profile
            }
        }
        return true; // Not attached to this shipping profile, so it could be.
    }
}
