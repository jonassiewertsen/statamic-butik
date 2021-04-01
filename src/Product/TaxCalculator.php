<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxRepository;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;
use Jonassiewertsen\Butik\Facades\Tax;

class TaxCalculator
{
    public TaxRepository $tax;
    public string|int $basePrice;

    public function __construct(
        public ProductRepository $product,
        public int $quantity = 1,
        string|null $locale = null,
    ) {
        $this->tax = Tax::for($this->product, $locale);
        $this->basePrice = $this->product->entry->get('price');
    }

    public function total(): PriceRepository
    {
        return $this->taxFromGrossPrice($this->basePrice);
    }

    public function single(): PriceRepository
    {
        return $this->taxFromGrossPrice($this->basePrice);
    }

    public function rate(): int
    {
        return $this->tax->rate;
    }

    protected function fromNetPrice($amount)
    {
        // TODO: Need implementing
    }

    protected function taxFromGrossPrice(mixed $amount): PriceRepository
    {
        $netPrice = PriceFacade::of($amount)->divide($this->tax->rate / 100 + 1);

        return PriceFacade::of($amount)
            ->subtract($netPrice)
            ->multiply($this->quantity);
    }
}
