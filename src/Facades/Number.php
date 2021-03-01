<?php

namespace Jonassiewertsen\StatamicButik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\StatamicButik\Contracts\NumberRepository;

class Number extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return NumberRepository::class;
    }
}
