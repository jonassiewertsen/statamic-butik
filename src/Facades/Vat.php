<?php

namespace Jonassiewertsen\Butik\Facades;

use Illuminate\Support\Facades\Facade;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\VatCalculator;

/**
 * @method static self of(mixed $amount)
 * @method static self withRate(float|int $rate)
 * @method static PriceRepository toNet()
 * @method static PriceRepository toGross()
 *
 * @see \Jonassiewertsen\Butik\Support\Vat
 */
class Vat extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(VatCalculator::class);

        return VatCalculator::class;
    }
}
