<?php

namespace Jonassiewertsen\StatamicButik\Shipping;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Symfony\Component\Intl\Countries;

class Country
{
    private const SESSION = 'butik.country';

    /**
     * We will get the country. In case no country has been defined, we will
     * fetch the default country from our config file.
     */
    public static function get()
    {
        return Session::get(self::SESSION, config('butik.country'));
    }

    public static function getName($country_code)
    {
        $country_code = strtoupper($country_code);

        if (Countries::exists($country_code)) {
            return Countries::getName($country_code, app()->getLocale());
        }

        return $country_code;
    }

    /**
     * Setting the country to our session
     */
    public static function set(string $code): void
    {
        if (Countries::exists($code) && self::list()->has($code)) {
            Session::put(self::SESSION, $code);
        }
    }

    public static function list()
    {
        return ShippingZone::all()->flatMap(function($shipping_zone) {
            return $shipping_zone->countries;
        })
        ->sort()
        ->mapWithKeys(function ($country_code) {
            return [$country_code => self::getName($country_code)];
        });
    }
}
