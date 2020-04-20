<?php


namespace Jonassiewertsen\StatamicButik\Checkout;

use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

class Item
{
    use MoneyTrait;

    /**
     * The id of the item, which does contain the product slug
     */
    public String $id;

    /**
     * The item name
     */
    public String $name;

    /**
     * The description, shortened to 100 characters
     */
    public String $description;

    /**
     * The product the item does base on
     */
    public Product $product;

    /**
     * The quanitity of this item in the shopping cart
     */
    private Int $quantity;

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
        $this->id               = $product->slug;
        $this->name             = $product->title;
        $this->description      = Str::limit($product->description, 100);
        $this->product          = $product;
        $this->quantity         = 1;
        $this->totalPrice       = $this->calculateTotalPrice();
        $this->totalShipping    = $this->calculateTotalShipping();

    }

    public function increase()
    {
        $this->quantity++;
        $this->update();
    }

    public function decrease()
    {
        if ($this->getQuantity() === 1) {
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

    public function totalShipping(): string
    {
        return $this->totalShipping;
    }

    public function singlePrice(): string
    {
        return $this->product->totalPrice;
    }

    private function calculateTotalPrice() {
        $price = $this->makeAmountSaveable($this->product->totalPrice);
        return $this->makeAmountHuman($price * $this->quantity);
    }

    private function calculateTotalShipping() {
        $shipping = $this->makeAmountSaveable($this->product->shipping_amount);
        return $this->makeAmountHuman($shipping * $this->quantity);
    }

    private function update(): void
    {
        $this->totalPrice       = $this->calculateTotalPrice();
        $this->totalShipping    = $this->calculateTotalShipping();
    }
}
