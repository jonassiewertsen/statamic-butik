<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Contracts\CartRepository;
use Jonassiewertsen\Butik\Contracts\PriceRepository;

/**
 * @method static Collection get()
 * @method static array raw()
 * @method static void add(string $slug, int $quantity = 1, string|null $locale = null)
 * @method static void reduce(string $slug)
 * @method static void update(string $slug, int $quanityt)
 * @method static void remove(string $slug)
 * @method static void clear()
 * @method static Customer|null customer()
 * @method static int count()
 * @method static PriceRepository totalPrice()
 * @method static PriceRepository totalShipping()
 * @method static Collection totalTaxes()
 * @method static Collection shipping()
 * @method static string country()
 * @method static void setCountry(string $isoCode)
 * @method static void removeNonSellableItems()
 * @method static bool contains(string $slug)
 *
 * @see \Jonassiewertsen\Butik\Cart\Cart
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CartRepository::class;
    }
}
