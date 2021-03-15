<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\ProductRepository;

class Product extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductRepository::class;
    }
}
