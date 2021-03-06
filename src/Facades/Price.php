<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\PriceRepository;

class Price extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PriceRepository::class;
    }
}
