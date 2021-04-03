<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxRepository;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;
use Jonassiewertsen\Butik\Facades\Tax;

class TaxCalculator
{
    public ProductRepository $product;
    public string|int $basePrice;
    public TaxRepository $tax;
    public bool $grossPrices;
    public int $quantity;

    public function __construct(ProductRepository $product, int $quantity = 1, string|null $locale = null) {
        $this->basePrice = $product->entry->get('price');
        $this->grossPrices = $this->isGrossPrice();
        $this->tax = Tax::for($product, $locale);
        $this->quantity = $quantity;
        $this->product = $product;
    }

    public function title(): string
    {
        return $this->tax->title;
    }

    public function total(): PriceRepository
    {
        return $this->grossPrices ?
            $this->taxFromGrossPrice($this->basePrice) :
            $this->taxFromNetPrice($this->basePrice);
    }

    public function single(): PriceRepository
    {
        return $this->grossPrices ?
            $this->taxFromGrossPrice($this->basePrice) :
            $this->taxFromNetPrice($this->basePrice);
    }

    public function rate(): int
    {
        return $this->tax->rate;
    }

    protected function taxFromNetPrice(mixed $amount): PriceRepository
    {
        /**
         * We are doing a basic tax calculation
         * amount * ( taxRate / 100 )
         * fx 100 * 0,19
         */
        return PriceFacade::of($amount)->multiply($this->tax->rate / 100)->multiply($this->quantity);
    }

    protected function taxFromGrossPrice(mixed $amount): PriceRepository
    {
        /**
         * To calcuate the tax amount from a gross price, we need to calculate
         * the net price first to continue.
         * amount / 1 + taxRate
         * fx. 119 / 1,19
         */
        $netPrice = PriceFacade::of($amount)->divide($this->tax->rate / 100 + 1);

        return PriceFacade::of($amount)
            ->subtract($netPrice)
            ->multiply($this->quantity);
    }

    private function isGrossPrice(): bool
    {
        return config('butik.price', 'gross') === 'gross';
    }
}
