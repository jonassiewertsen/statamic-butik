<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\VatCalculator;

class Vat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(VatCalculator::class);

        return VatCalculator::class;
    }
}
