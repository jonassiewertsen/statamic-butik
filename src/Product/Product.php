<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
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

    public function tax(): TaxCalculator
    {
        return new TaxCalculator($this);
    }

    public function taxType(): string
    {
        return (string) $this->data['tax'];
    }

    public function price(): object
    {
        return (object) $this->entry->augmentedValue('price')->value();
    }

    public function toArray(): array
    {
        return []; // TODO: Implement
    }
}
