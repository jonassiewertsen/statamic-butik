<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceCalculator as PriceCalculatorContract;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator as TaxCalculatorContract;
use Jonassiewertsen\Butik\Product\Calculator\TaxCalculator;
use Jonassiewertsen\Butik\Support\ButikEntry;

class Product extends ButikEntry implements ProductRepository
{
    public function collection(): string
    {
        return 'products'; // TODO: Get from config
    }

    public function stock(): int
    {
        return (int) $this->data['stock'];
    }

    public function stockUnlimited(): bool
    {
        return $this->data['stock_unlimited'];
    }

    public function tax(int $quantity = 1): TaxCalculatorContract
    {
        return new TaxCalculator($this, $quantity);
    }

    public function taxType(): string
    {
        return (string) $this->data['tax'];
    }

    public function price(int $quantity = 1): PriceCalculatorContract
    {
        return new Price($this, $quantity);
    }

    public function toArray(): array
    {
        return []; // TODO: Implement
    }
}
