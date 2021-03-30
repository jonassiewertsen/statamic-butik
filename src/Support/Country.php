<?php

namespace Jonassiewertsen\Butik\Support;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\Butik\Contracts\CountryRepository;
use Jonassiewertsen\Butik\Exceptions\ButikConfigException;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Symfony\Component\Intl\Countries as IntlCountries;

class Country implements CountryRepository
{
    public ?string $isoCode;

    private const SESSION = 'butik.country';

    public function __construct()
    {
        $this->isoCode = $this->fromSession();
    }

    /**
     * Will return the localized country name.
     */
    public function name(?string $isoCode = null): string|null
    {
        $isoCode = strtoupper($isoCode ?? $this->isoCode);

        if (! $this->exists($isoCode)) {
            return null;
        }

        return IntlCountries::getName($isoCode, app()->getLocale());
    }

    public function iso(): string
    {
        return $this->isoCode;
    }

    /**
     * Setting the country to our session.
     */
    public function set(string $isoCode): bool
    {
        if (! $this->exists($isoCode)) {
            return false;
        }

        $this->isoCode = $isoCode;
        Session::put(self::SESSION, $isoCode);

        return true;
    }

    /**
     * Returning all countries, used by any Shipping Profile.
     */
    public function list(): array // Not defined inside the country repository interface
    {
        // TODO: Move to ShippingFacade
        return ShippingZone::all()
            ->unique()
            ->flatMap(fn ($shippingZone) => $shippingZone->countries)
            ->sort()
            ->mapWithKeys(fn ($isoCode) => [$isoCode => self::name($isoCode)]);
    }

    /**
     * Returning the default country code from the config file.
     */
    public function defaultName(): string
    {
        return $this->name(config('butik.country'));
    }

    /**
     * Returning the default country code from the config file.
     */
    public function defaultIso(): string
    {
        return config('butik.country');
    }

    /**
     * Checking if the given country code does exist.
     */
    public function exists(string $isoCode): bool
    {
        return IntlCountries::exists($isoCode);
    }

    private function fromSession(): string|null
    {
        $isoCode = Session::get(self::SESSION, $this->defaultIso());

        return $this->exists($isoCode) ? $isoCode : throw new ButikConfigException("Country with ISO code \".$isoCode.\" doesn't exist");
    }
}
