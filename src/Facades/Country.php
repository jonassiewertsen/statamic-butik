<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\CountryRepository;

/**
 * @method static string|null name(string|null $isoCode = null)
 * @method static string iso()
 * @method static bool set(string $isoCode)
 * @method static string defaultName()
 * @method static string defaultIso()
 * @method static bool exists(string $isoCode)
 *
 * @see \Jonassiewertsen\Butik\Support\Country
 */
class Country extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CountryRepository::class;
    }
}
