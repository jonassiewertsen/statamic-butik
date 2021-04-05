<?php

namespace Jonassiewertsen\Butik\Contracts;

interface ProductRepository
{
    public function price(): PriceCalculator;

    public function stock(): int;

    public function stockUnlimited(): bool;

    public function tax(): TaxCalculator;

    public function taxType(): string;
}
