<?php

namespace Jonassiewertsen\Butik\Contracts;

interface ProductRepository
{
    public function stock(): int;

    public function tax(): TaxCalculator;

    public function taxType(): string;

    public function price(): PriceCalculator;

    public function stockUnlimited(): bool;
}
