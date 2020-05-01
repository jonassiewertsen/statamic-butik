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
     * Will return the total price of the item
     */
    private $totalPrice;

    /**
     * Will return the total price of the item
     */
    private $totalShipping;

    public function __construct(Product $product)
    {
        $this->available      = $product->available;
        $this->id             = $product->slug;
        $this->name           = $product->title;
        $this->description    = $this->limitDescription($product->description);
        $this->taxRate        = $product->tax->percentage;
        $this->quantity       = 1;
        $this->availableStock = $product->stock;
        $this->base_price     = $product->base_price;
        $this->totalPrice     = $this->calculateTotalPrice();
        $this->totalShipping  = $this->calculateTotalShipping();
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

    public function setQuantity(int $quanitity): void
    {
        $this->quantity = $quanitity;
        $this->update();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function totalPrice(): string
    {
        return $this->totalPrice;
    }

    public function singleShipping(): string
    {
        return $this->product()->shipping->price;
    }

    public function totalShipping(): string
    {
        return $this->totalShipping;
    }

    public function singlePrice(): string
    {
        return $this->product()->totalPrice;
    }

    private function calculateTotalPrice()
    {
        $price = $this->makeAmountSaveable($this->product()->totalPrice);
        return $this->makeAmountHuman($price * $this->quantity);
    }

    private function calculateTotalShipping()
    {
        $shipping = $this->makeAmountSaveable($this->product()->shipping_amount);
        return $this->makeAmountHuman($shipping * $this->quantity);
    }

    public function update(): void
    {
        if (! $this->StockAvailable()) {
            $this->setQuantityToStock();
        }

        if (! $this->product()->available) {
            $this->quantity = 0;
        }

        $this->available      = $this->product()->available;
        $this->availableStock = $this->product()->stock;
        $this->base_price     = $this->product()->base_price;
        $this->description    = $this->limitDescription($this->product()->description);
        $this->totalPrice     = $this->calculateTotalPrice();
        $this->totalShipping  = $this->calculateTotalShipping();
    }

    private function limitDescription($text)
    {
        return Str::limit($text, 100, '...');
    }

    private function product(): Product
    {
        $cacheName = "product:{$this->id}";

        return Cache::remember($cacheName, 300, function () {
           return  Product::find($this->id);
        });
    }

    private function setQuantityToStock(): void
    {
        $this->setQuantity($this->product()->stock);
    }

    private function stockAvailable() {
        return $this->getQuantity() <= $this->product()->stock;
    }
}
