<?php

namespace Jonassiewertsen\Butik\Cart;

use Jonassiewertsen\Butik\Contracts\PriceCalculator;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Support\Traits\getProduct;

class Item
{
    public string $slug;
    private int $quantity;
    private bool $available;
    private bool $isSellableInCurrenctCountry;

    use getProduct;

    public function __construct(mixed $identifier, int $quantity = 1)
    {
        $product = $this->getProduct($identifier);
        $this->slug = $product->slug;
        $this->quantity = $quantity;
        $this->available = $product->published;
        $this->isSellableInCurrenctCountry = true;
    }

    public function product(): ProductRepository
    {
        return $this->getProduct($this->slug);
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function price(): PriceCalculator
    {
        return $this->product->price($this->quantity);
    }

    public function tax(): TaxCalculator
    {
        return $this->product->tax($this->quantity);
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function isSellable(): bool
    {
        return $this->isSellableInCurrenctCountry;
    }

    public function sellable(): void
    {
        $this->isSellableInCurrenctCountry = true;
    }

    public function nonSellable(): void
    {
        $this->isSellableInCurrenctCountry = false;
    }

    public function stock(): int
    {
        return $this->product->stock;
    }

    public function stockUnlimited(): bool
    {
        return $this->product->stockUnlimited;
    }

    public function __get($name)
    {
        if ($name === 'product') {
            return $this->product();
        }
    }
}
