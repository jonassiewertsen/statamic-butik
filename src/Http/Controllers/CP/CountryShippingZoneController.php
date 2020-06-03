<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

class CountryShippingZoneController extends CpController
{
    public function index(ShippingZone $shippingZone)
    {
        $countries = Country::all();

        return $countries->map(function ($country) use ($shippingZone) {
            return [
                'name'            => $country->name,
                'slug'            => $country->slug,
                'iso'             => $country->iso,
                'current_zone'    => $country->inCurrentZone($shippingZone),
                'can_be_attached' => $country->attachableTo($shippingZone->profile),
            ];
        });
    }
}
