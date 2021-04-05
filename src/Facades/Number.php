<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\NumberRepository;

/**
 * @method static self of(mixed $number)
 * @method static self add(mixed $number)
 * @method static self subtract(mixed $number)
 * @method static self multiply(float|int $by)
 * @method static self divide(float|int $by)
 * @method static string get()
 * @method static float decimal()
 * @method static int int()
 *
 * @see \Jonassiewertsen\Butik\Support\Number
 */
class Number extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(NumberRepository::class);

        return NumberRepository::class;
    }
}
