<?php

namespace Jonassiewertsen\Butik\Contracts;

use Jonassiewertsen\Butik\Product\TaxCalculator;

interface ProductRepository
{
    public function stock(): int;

    public function tax(): TaxCalculator; // TODO: Swap with Interface!

    public function taxType(): string;

    public function price(): object;

    public function stockUnlimited(): bool;
}
