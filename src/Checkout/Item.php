<?php


namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class Item
{
    use MoneyTrait;

    /**
     * Is this item available
     */
    public bool $available;

    /**
     * How many times can the product be sold.
     */
    public int $availableStock;

    /**
     * The id of the item, which does contain the product slug
     */
    public string $id;

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

    public function __construct(Product $product)
    {
        $this->available      = $product->available;
        $this->id             = $product->slug;
        $this->name           = $product->title;
        $this->description    = $this->limitDescription($product->description);
        $this->taxRate        = $product->tax->percentage;
        $this->quantity       = 1;
        $this->availableStock = $product->stock;
        $this->singlePrice    = $product->price;
        $this->totalPrice     = $this->totalPrice();
    }

    public function increase()
    {
        if ($this->getQuantity() >= $this->product()->stock) {
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

        if ($this->getQuantity() > $this->product()->stock) {
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
        return $this->product()->price;
    }

    public function totalPrice()
    {
        $price = $this->makeAmountSaveable($this->product()->price);
        return $this->makeAmountHuman($price * $this->quantity);
    }

    public function update(): void
    {
        if (!$this->StockAvailable()) {
            $this->setQuantityToStock();
        }

        if (!$this->product()->available) {
            $this->quantity = 0;
        }

        $this->available      = $this->product()->available;
        $this->availableStock = $this->product()->stock;
        $this->singlePrice    = $this->product()->price;
        $this->description    = $this->limitDescription($this->product()->description);
        $this->totalPrice     = $this->totalPrice();
    }

    private function limitDescription($text)
    {
        return Str::limit($text, 100, '...');
    }

    private function product(): Product
    {
        $cacheName = "product:{$this->id}";

        return Cache::remember($cacheName, 300, function () {
            return Product::find($this->id);
        });
    }

    private function setQuantityToStock(): void
    {
        $this->setQuantity($this->product()->stock);
    }

    private function stockAvailable()
    {
        return $this->getQuantity() <= $this->product()->stock;
    }
}
