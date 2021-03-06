<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\CartRepository;

class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CartRepository::class;
    }
}
