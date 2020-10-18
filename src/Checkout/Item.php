<?php


namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Product as ProductModel;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Statamic\Facades\Site;
use Statamic\Fields\Value;

class Item
{
    use MoneyTrait;

    /**
     * Is this item available
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
     * The id of the item, which does contain the product slug
     */
    public string $slug;

    /**
     * The images of the item
     */
    public ?Value $images;

    /**
     * The item name
     */
    public string $name;

    /**
     * The locale the item has been added from
     */
    public ?string $locale;

    /**
     * The description, shortened to 100 characters
     */
    public ?string $description;

    /**
     * The product the item does base on
     */
    public ProductModel $product;

    /**
     * The variant we do use. Null if not defined
     */
    public Variant $variant;

    /**
     * The tax amount of the product
     */
    public string $taxAmount;

    /**
     * The taxrate of the product
     */
    public int $taxRate;

    /**
     * The quanitity of this item in the shopping cart
     */
    private int $quantity;

    /**
     * Will return the price of the item
     */
    private string $singlePrice;

    /**
     * Will return the cumulated price. The itemquantity multiplied with the single Price
     */
    private string $totalPrice;

    public function __construct(string $slug, ?string $locale = null)
    {
        $this->slug   = $slug;
        $this->locale = $locale;

        $this->setCurrentLocale();
        $item = $this->defineItemData();

        $this->available       = $item->available;
        $this->sellable        = true;
        $this->quantity        = 1;
        $this->availableStock  = (int)$item->stock;
        $this->singlePrice     = (string)$item->price;
        $this->name            = (string)$item->title;
        $this->images          = $this->convertImage($this->product->images);
        $this->description     = $this->limitedDescription();
        $this->taxRate         = $item->tax->percentage;
        $this->taxAmount       = $this->totalTaxAmount();
        $this->totalPrice      = $this->totalPrice();
        $this->shippingProfile = $item->shipping_profile;
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

        if ($this->getQuantity() > $this->item()->stock) {
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
        $price = $this->makeAmountSaveable($this->singlePrice);
        return $this->makeAmountHuman($price * $this->quantity);
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

        $this->available      = $this->item()->available;
        $this->availableStock = $this->item()->stock;
        $this->singlePrice    = $this->item()->price;
        $this->description    = $this->limitedDescription();
        $this->totalPrice     = $this->totalPrice();
        $this->taxAmount      = $this->totalTaxAmount();

        return true;
    }

    public function totalTaxAmount()
    {
        $totalPrice = $this->makeAmountSaveable($this->totalPrice());
        $tax        = $totalPrice * ($this->taxRate / (100 + $this->taxRate));
        return $this->makeAmountHuman($tax);
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

    private function product(): ProductModel
    {
        $cacheName = "product:{$this->productSlug()}:{$this->locale}";

        return Cache::remember($cacheName, 60, function () {
            return Product::find($this->productSlug());
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
