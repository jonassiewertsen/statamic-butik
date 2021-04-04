<?php

namespace Jonassiewertsen\Butik\Product\Calculator;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Facades\Vat;

class GrossPriceCalculator extends PriceCalculator
{
    public function single(): PriceRepository
    {
        return $this->isGrossPrice() ?
            Price::of($this->base()) :
            Vat::of($this->base())->withRate($this->tax->rate())->toGross();
    }
}
