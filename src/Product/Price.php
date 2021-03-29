<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;

class Price
{
    public function __construct(
        public ProductRepository $product,
        public int $quantity = 1
    ) {}

    public function total(): PriceRepository
    {
        return PriceFacade::of($this->price())->multiply($this->quantity);
    }

    public function single(): PriceRepository
    {
        return PriceFacade::of($this->price());
    }

    private function price(): string
    {
        return $this->product->entry->get('price');
    }
}
