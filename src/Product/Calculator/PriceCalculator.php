<?php

namespace Jonassiewertsen\Butik\Product\Calculator;

use Jonassiewertsen\Butik\Contracts\PriceContract;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator as TaxCalculatorContract;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Support\Traits\isGrossPrice;

abstract class PriceCalculator implements PriceContract
{
    use isGrossPrice;

    public ProductRepository $product;
    public TaxCalculatorContract $tax;
    public int $quantity;

    public function __construct(ProductRepository $product, int $quantity = 1)
    {
        $this->product = $product;
        $this->tax = $product->tax();
        $this->quantity = $quantity;
    }

    public function get(): string
    {
        return $this->total()->get();
    }

    abstract public function single(): PriceRepository;

    public function total(): PriceRepository
    {
        return $this->single()->multiply($this->quantity);
    }

    public function base(): PriceRepository
    {
        return Price::of($this->product->entry->get('price'));
    }
}
