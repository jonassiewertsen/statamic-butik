<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;

class TaxCalculator
{
    public function __construct(
        public ProductRepository $product,
        public int $quantity = 1
    ) {}

    public function total(): PriceRepository
    {
        return PriceFacade::of($this->tax()['amount'])->multiply($this->quantity);
    }

    public function single(): PriceRepository
    {
        return PriceFacade::of($this->tax()['amount']);
    }

    public function rate(): int
    {
        return $this->tax()['rate'];
    }

    private function tax(): array
    {
        return $this->product->entry->augmentedValue('tax_id')->value();
    }
}
