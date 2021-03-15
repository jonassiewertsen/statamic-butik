<?php

namespace Jonassiewertsen\Butik\Checkout;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Facades\Product;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Statamic\Facades\Site;
use Statamic\Fields\Value;

class Item
{
    /**
     * Is this item available.
     */
    public bool $available;

    /**
     * Is the item sellable in the selected country?
     */
    public bool $sellable;

    /**
     * How many times can the product be sold.
     */
    public int $availableStock;

    /**
     * The id of the item, which does contain the product slug.
     */
    public string $slug;

    /**
     * The images of the item.
     */
    public ?Value $images;

    /**
     * The item name.
     */
    public string $name;

    /**
     * The locale the item has been added from.
     */
    public ?string $locale;

    /**
     * The description, shortened to 100 characters.
     */
    public ?string $description;

    /**
     * The product the item does base on.
     */
    public ProductRepository $product;

    /**
     * The variant we do use. Null if not defined.
     */
    public Variant $variant;

    /**
     * All tax information.
     */
    public object $tax;

    /**
     * The quanitity of this item in the shopping cart.
     */
    private int $quantity;

    /**
     * Will return the price of the item.
     */
    private object $singlePrice;

    /**
     * Will return the cumulated price. The itemquantity multiplied with the single Price.
     */
    private object $totalPrice;

    public function __construct(string $slug, ?string $locale = null)
    {
        $this->slug = $slug;
        $this->locale = $locale;

        $this->setCurrentLocale();
        $item = $this->defineItemData();

        $this->available = $item->published;
        $this->sellable = true;
        $this->quantity = 1;
        $this->availableStock = $item->stock;
//        $this->unlimited = $item->stockUnlimited();
        $this->singlePrice = $item->price;
        $this->title = $item->title;
//        $this->images = $this->convertImage($this->product->images);
        $this->description = $this->limitedDescription();
        $this->tax = $item->tax;
//        $this->totalPrice = $this->totalPrice();
//        $this->shippingProfile = $item->shipping_profile;
    }

    public function increase()
    {
        if (! $this->isIncreasable()) {
            $this->setQuantityToStock();

            return;
        }

        $this->quantity++;
        $this->update();
    }

    public function decrease()
    {
        if ($this->getQuantity() === 1) {
            return;
        }

        if ($this->lessAvailableThenInCart()) {
            $this->setQuantityToStock();

            return;
        }

        $this->quantity--;
        $this->update();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quanitity): void
    {
        $this->quantity = $quanitity;
        $this->update();
    }

    public function singlePrice(): string
    {
        return $this->item()->price;
    }

    public function totalPrice()
    {
        return Price::of($this->singlePrice->total)
                ->multiply($this->quantity)
                ->get();
    }

    public function sellable(): void
    {
        $this->sellable = true;
    }

    public function nonSellable(): void
    {
        $this->sellable = false;
    }

    public function update(): bool
    {
        /**
         * We won't update the cart, if the product does not exist anymore.
         */
        if (! Product::exists($this->productSlug())) {
            return false;
        }

        $this->defineItemData();

        if (! $this->StockAvailable() && ! $this->isIncreasable()) {
            $this->setQuantityToStock();
        }

        if (! $this->item()->available) {
            $this->quantity = 0;
        }

        $this->available = $this->item()->available;
        $this->availableStock = $this->item()->stock;
        $this->singlePrice = $this->item()->price;
        $this->description = $this->limitedDescription();
        $this->totalPrice = $this->totalPrice();
        $this->taxAmount = $this->totalTaxAmount();

        return true;
    }

    public function totalTaxAmount()
    {
        return Price::of($this->totalPrice())
                ->multiply($this->taxRate / 100)
                ->get();
    }

    protected function isVariant()
    {
        return Str::contains($this->slug, '::');
    }

    private function isIncreasable()
    {
        if ($this->item()->stock_unlimited) {
            return true;
        }

        if ($this->getQuantity() < $this->item()->stock) {
            return true;
        }

        return false;
    }

    private function limitedDescription()
    {
        return Str::limit($this->product()->description, 100, '...');
    }

    private function product(): ProductRepository
    {
        $cacheName = "product:{$this->productSlug()}:{$this->locale}";

        return Cache::remember($cacheName, 20, function () {
            return Product::findBySlug($this->productSlug());
        });
    }

    private function setQuantityToStock(): void
    {
        $this->setQuantity($this->item()->stock);
    }

    private function stockAvailable()
    {
        return $this->getQuantity() <= $this->item()->stock;
    }

    private function lessAvailableThenInCart(): bool
    {
        if ($this->unlimited) {
            return false;
        }

        return $this->getQuantity() > $this->item()->stock;
    }

    private function defineItemData()
    {
        Site::setCurrent($this->locale);

        if ($this->isVariant()) {
            $this->product = $this->product();

            return $this->variant = Variant::find($this->variantSlug());
        } else {
            return $this->product = $this->product();
        }
    }

    private function productSlug()
    {
        if (! $this->isVariant()) {
            return $this->slug;
        }

        return Str::of($this->slug)->explode('::')[0];
    }

    private function variantSlug()
    {
        if (! $this->isVariant()) {
            return null;
        }

        return Str::of($this->slug)->explode('::')[1];
    }

    private function item()
    {
        return $this->isVariant() ?
            $this->variant :
            $this->product;
    }

    private function convertImage($images)
    {
        if (! $images) {
            return null;
        }

        return $images;
    }

    private function setCurrentLocale(): void
    {
        Site::setCurrent($this->locale);
    }
}
