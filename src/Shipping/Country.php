<?php


namespace Jonassiewertsen\StatamicButik\Shipping;


use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Models\Country as CountryModel;

class Country
{
    private const SESSION = 'butik.country';

    /**
     * We will get the country. In case no country has been defined, we will
     * fetch the default country from our config file.
     */
    public static function get($returnArray = true)
    {
        if (Session::exists(self::SESSION)) {
            $country = Session::get(self::SESSION);
            return $returnArray ? $country->toArray() : $country;
        }

        $country =  self::getDefaultCountryFromConfig();

        return $returnArray ? $country->toArray() : $country;
    }

    /**
     * Setting the country to our session
     */
    public static function set(string $name): void
    {
        $country = static::fetchCountryModel($name);
        Session::put(self::SESSION, $country);
    }

    /**
     * Fetching all needed information from our country model
     */
    protected static function fetchCountryModel($slug): CountryModel
    {
        $country =  CountryModel::where('slug', 'LIKE', '%' . $slug . '%')->first();

        if ($country === null) {
            throw new ButikConfigException('The defined Country with the slug "' . $slug . '" does not exist.');
        }

        return $country;
    }

    /**
     * Getting our default country from our config file.
     */
    private static function getDefaultCountryFromConfig()
    {
        $country = config('butik.country');

        return static::fetchCountryModel($country);
    }
}
