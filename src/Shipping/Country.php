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
     * fetch the default country from the config file.
     */
    public static function get(): string
    {
        return Session::get(self::SESSION, self::getDefault());
    }

    /**
     * Will return the localized country name.
     */
    public static function getName(string $countryCode): ?string
    {
        $countryCode = strtoupper($countryCode);

        if (! self::exists($countryCode)) {
            return null;
        }

        return Countries::getName($countryCode, app()->getLocale());
    }

    /**
     * Setting the country to our session.
     */
    public static function set(string $countryCode): void
    {
        if (self::exists($countryCode) && self::list()->has($countryCode)) {
            Session::put(self::SESSION, $countryCode);
        }
    }

    /**
     * Returning all countries, used by any Shipping Profile.
     */
    public static function list()
    {
        return ShippingZone::all()
            ->unique()
            ->flatMap(fn ($shippingZone) => $shippingZone->countries)
            ->sort()
            ->mapWithKeys(fn ($countryCode) => [$countryCode => self::getName($countryCode)]);
    }

    /**
     * Returning the default country code from the config file.
     */
    private static function getDefault(): string
    {
        $country = config('butik.country');

        if (! self::exists($country)) {
            throw new ButikConfigException("Country with ISO code \"$country\" doesn't exist");
        }

        return $country;
    }

    /**
     * Checking if the given country code does exist.
     */
    private static function exists($countryCode)
    {
        return Countries::exists($countryCode);
    }
}
