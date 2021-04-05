<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\PriceCalculator;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Contracts\TaxRepository;
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
 * @method static float|int rate()
 * @method static string type()
 * @method static TaxRepository|null for(ProductRepository $product, string|null $locale = null)
 *
 * @see \Jonassiewertsen\Butik\Repositories\TaxRepository
 */
class Tax extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TaxRepository::class;
    }
}
