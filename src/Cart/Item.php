<?php

namespace Jonassiewertsen\Butik\Cart;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Facades\Product;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Statamic\Contracts\Entries\Entry;
use Statamic\Facades\Site;
use Statamic\Fields\Value;

class Item
{
    public bool $available;
    public bool $sellableInCurrenctCountry;
    public string $productId;
    public int $availableStock;
    private int $quantity;
    private object $singlePrice;
    private string $totalPrice;

    // Saving in cart
    // - product id
    // - quantity

    public function __construct(string $slug, int )
    {
        $this->productId = $productId;
    }

    public function increase()
    {
//        if (! $this->isIncreasable()) {
//            $this->setQuantityToStock();
//
//            return;
//        }
//
//        $this->quantity++;
//        $this->update();
    }

    public function decrease()
    {
//        if ($this->getQuantity() === 1) {
//            return;
//        }
//
//        if ($this->lessAvailableThenInCart()) {
//            $this->setQuantityToStock();
//
//            return;
//        }
//
//        $this->quantity--;
//        $this->update();
    }

    public function quantity(): int // TODO: Needed?
    {
        return $this->quantity;
    }

    public function sellable(): void
    {
        $this->sellable = true;
    }

    public function nonSellable(): void
    {
        $this->sellable = false;
    }

    public function totalTaxAmount()
    {
//        return Price::of($this->totalPrice())
//                ->multiply($this->taxRate / 100)
//                ->get();
    }

    private function isIncreasable()
    {
//        if ($this->item()->stock_unlimited) {
//            return true;
//        }
//
//        if ($this->getQuantity() < $this->item()->stock) {
//            return true;
//        }
//
//        return false;
    }

    private function product(): ProductRepository
    {
//        $cacheName = "product:{$this->productSlug()}:{$this->locale}";
//
//        return Cache::remember($cacheName, 20, function () {
//            return Product::findBySlug($this->productSlug());
//        });
    }

//    private function setQuantityToStock(): void
//    {
//        $this->setQuantity($this->item()->stock);
//    }

//    private function stockAvailable()
//    {
//        return $this->getQuantity() <= $this->item()->stock;
//    }
//
//    private function lessAvailableThenInCart(): bool
//    {
//        if ($this->unlimited) {
//            return false;
//        }
//
//        return $this->getQuantity() > $this->item()->stock;
//    }

//    private function productSlug()
//    {
//        if (! $this->isVariant()) {
//            return $this->slug;
//        }
//
//        return Str::of($this->slug)->explode('::')[0];
//    }

//    private function setCurrentLocale(): void
//    {
//        Site::setCurrent($this->locale);
//    }
}
