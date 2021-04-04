<?php

namespace Jonassiewertsen\Butik\Product;

use Jonassiewertsen\Butik\Contracts\PriceRepository;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator as TaxCalculatorContract;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;
use Jonassiewertsen\Butik\Facades\Tax;
use Jonassiewertsen\Butik\Facades\Vat;
use Jonassiewertsen\Butik\Http\Traits\isGrossPrice;

class TaxCalculator implements TaxCalculatorContract
{
    use isGrossPrice;

    public ProductRepository $product;
    public string|int $basePrice;
    public TaxRepository|null $tax;
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
        return $this->isGrossPrice() ?
            $this->taxFromGrossPrice($this->basePrice) :
            $this->taxFromNetPrice($this->basePrice);
    }

    public function single(): PriceRepository
    {
        return $this->isGrossPrice() ?
            $this->taxFromGrossPrice($this->basePrice) :
            $this->taxFromNetPrice($this->basePrice);
    }

    public function rate(): int // TODO: What about comma taxes like in switzerland?
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
         * To calcuate the tax amount from a gross price, we need
         * to substract the net price from the gross price.
         */
        $netPrice = Vat::of($amount)->withRate($this->tax->rate)->toNet();

        return PriceFacade::of($amount)->subtract($netPrice)->multiply($this->quantity);
    }
}
