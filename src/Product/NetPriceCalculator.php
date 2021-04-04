<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Facades\Price;

class NetPriceCalculator extends PriceCalculator
{
    public function single(): PriceRepository
    {
        return $this->isGrossPrice() ?
            Price::of($this->base())->subtract($this->tax->single()) :
            Price::of($this->base());
    }
}
