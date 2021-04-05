<?php

namespace Jonassiewertsen\Butik\Cart;

use Jonassiewertsen\Butik\Contracts\PriceCalculator;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Facades\Product;

class Item
{
    public string $slug;
    public ProductRepository $product;
    private bool $available;
    private bool $isSellableInCurrenctCountry;
    private int $quantity;

    public function __construct(string $slug, int $quantity = 1)
    {
        // TODO: Handle the case that a product does not exist.

        $this->slug = $slug;
        $this->quantity = $quantity;
        $this->product = Product::findBySlug($slug);
        $this->available = $this->product->published;
        $this->isSellableInCurrenctCountry = true;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function price(): PriceCalculator
    {
        return $this->product->price();
    }

    public function tax(): TaxCalculator
    {
        return $this->product->tax();
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
}
