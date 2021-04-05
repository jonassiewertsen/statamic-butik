<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\PriceRepository;

/**
 * @method static self of(mixed $number)
 * @method static self add(mixed $number)
 * @method static self subtract(mixed $number)
 * @method static self multiply(float|int $by)
 * @method static self delimiter(string $delimiter)
 * @method static self thousands(string $thousands)
 * @method static string get()
 * @method static int cents()
 *
 * @see \Jonassiewertsen\Butik\Support\Price
 */
class Price extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(PriceRepository::class);

        return PriceRepository::class;
    }
}
