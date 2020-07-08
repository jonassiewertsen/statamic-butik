<?php


namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

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
     * The item name
     */
    public string $name;

    /**
     * The description, shortened to 100 characters
     */
    public ?string $description;

    /**
     * The product the item does base on
     */
    public Product $product;

    /**
     * The variant we do use. Null if not defined
     */
    public Variant $variant;

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

    public function __construct(string $slug)
    {
        $this->slug = $slug;

        $item = $this->defineItemData();

        $this->available       = $item->available;
        $this->sellable        = true;
        $this->name            = $item->title;
        $this->description     = $this->limitDescription($this->product->description);
        $this->taxRate         = $item->tax->percentage;
        $this->quantity        = 1;
        $this->availableStock  = $item->stock;
        $this->singlePrice     = $item->price;
        $this->totalPrice      = $this->totalPrice();
        $this->shippingProfile = $item->shippingProfile;
    }

    public function increase()
    {
        if ($this->getQuantity() >= $this->item()->stock) {
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

    public function update(): void
    {
        $this->defineItemData();

        if (!$this->StockAvailable()) {
            $this->setQuantityToStock();
        }

        if (!$this->item()->available) {
            $this->quantity = 0;
        }

        $this->available      = $this->item()->available;
        $this->availableStock = $this->item()->stock;
        $this->singlePrice    = $this->item()->price;
        $this->description    = $this->limitDescription($this->product()->description);
        $this->totalPrice     = $this->totalPrice();
    }

    private function limitDescription($text)
    {
        return Str::limit($text, 100, '...');
    }

    private function product(): Product
    {
        $cacheName = "product:{$this->productSlug()}";

        return Cache::remember($cacheName, 300, function () {
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

    protected function isVariant()
    {
        return Str::contains($this->slug, '::');
    }

    private function defineItemData()
    {
        if ($this->isVariant()) {
            $this->product = $this->product();
            return $this->variant = Variant::find($this->variantSlug());
        } else {
            return $this->product =  $this->product();
        }
    }

    private function productSlug() {
        if (! $this->isVariant()) {
            return $this->slug;
        }

        return Str::of($this->slug)->explode('::')[0];
    }

    private function variantSlug() {
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
}
