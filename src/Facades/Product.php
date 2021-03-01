<?php

namespace Jonassiewertsen\StatamicButik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\StatamicButik\Contracts\ProductRepository;

class Product extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductRepository::class;
    }
}
