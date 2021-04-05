<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Contracts\CartRepository;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Http\Responses\CartResponse;

/**
 * @method static Collection get()
 * @method static array raw()
 * @method static CartResponse add(string $slug, int $quantity = 1, string|null $locale = null)
 * @method static CartResponse update(string $slug, int $quantity)
 * @method static CartResponse remove(string $slug)
 * @method static CartResponse clear()
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
