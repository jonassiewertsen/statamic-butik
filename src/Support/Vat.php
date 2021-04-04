<?php

namespace Jonassiewertsen\Butik\Support;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\VatCalculator;
use Jonassiewertsen\Butik\Facades;

class Vat implements VatCalculator
{
    public PriceRepository $amount;
    public float|int $rate;

    public function of(mixed $amount): self
    {
        $this->amount = Facades\Price::of($amount);

        return $this;
    }

    public function withRate(float|int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function toNet(): PriceRepository
    {
        /**
         * To calcuate the vat amount from a gross price, we will convert the raste as shown:
         * amount / taxRate + 1
         * fx. 119 / 1,19
         */
        return $this->amount->divide($this->rate / 100 + 1);
    }

    public function toGross(): PriceRepository
    {
        /**
         * We are doing a basic tax calculation
         * amount * taxRate / 100 + 1
         * fx 100 * 1,19
         */
        return $this->amount->multiply($this->rate / 100  + 1);
    }
}
