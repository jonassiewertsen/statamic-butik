<?php

namespace Jonassiewertsen\StatamicButik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\StatamicButik\Contracts\CartRepository;

class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CartRepository::class;
    }
}
