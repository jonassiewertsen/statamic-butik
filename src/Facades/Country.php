<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\CountryRepository;

class Country extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CountryRepository::class;
    }
}
