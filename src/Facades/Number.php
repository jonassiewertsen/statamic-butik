<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\NumberRepository;

class Number extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NumberRepository::class;
    }
}
