<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\PriceCalculator;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Statamic\Contracts\Entries\QueryBuilder;

/**
 * @method static Collection all()
 * @method static self|null find(string $id)
 * @method static self|null findBySlug(string $slug)
 * @method static bool exists(string $slug)
 * @method static QueryBuilder query(string $slug)
 * @method static bool update(array $data)
 * @method static bool delete(string $id)
 * @method static string collection()
 * @method static array toArray()
 *
 * @method static PriceCalculator price()
 * @method static int stock()
 * @method static bool stockUnlimited()
 * @method static TaxCalculator tax()
 * @method static string taxType()
 *
 * @see \Jonassiewertsen\Butik\Product\Product
 */
class Product extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductRepository::class;
    }
}
