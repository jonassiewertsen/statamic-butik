<?php

namespace Jonassiewertsen\Butik\Contracts;

interface VatCalculator
{
    public function of(mixed $amount): self;

    public function withRate(float | int $rate): self;

    public function toNet(): PriceRepository;

    public function toGross(): PriceRepository;
}
