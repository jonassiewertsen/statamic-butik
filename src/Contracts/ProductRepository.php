<?php

namespace Jonassiewertsen\Butik\Contracts;

interface ProductRepository
{
    public function price(int $quantity = 1): PriceCalculator;

    public function stock(): int;

    public function stockUnlimited(): bool;

    public function tax(int $quantity = 1): TaxCalculator;

    public function taxType(): string;
}
