<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\TaxRepository;

class Tax extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TaxRepository::class;
    }
}
