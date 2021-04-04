<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceContract;
use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\PriceCalculator as PriceCalculatorContract;
use Jonassiewertsen\Butik\Contracts\TaxCalculator as TaxCalculatorContract;
use Jonassiewertsen\Butik\Facades;
use Jonassiewertsen\Butik\Http\Traits\isGrossPrice;

class Price implements PriceCalculatorContract
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
        return $this->isGrossPrice() ?
            $this->gross()->total()->get() :
            $this->net()->total()->get();
    }

    public function net(): PriceContract
    {
        return new NetPriceCalculator($this->product, $this->quantity);
    }

    public function gross(): PriceContract
    {
        return new GrossPriceCalculator($this->product, $this->quantity);
    }

    public function base(): PriceRepository
    {
        return Facades\Price::of($this->product->entry->get('price'));
    }
}
