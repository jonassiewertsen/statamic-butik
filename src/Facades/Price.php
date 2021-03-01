<?php

namespace Jonassiewertsen\StatamicButik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\StatamicButik\Contracts\PriceRepository;

class Price extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PriceRepository::class;
    }
}
