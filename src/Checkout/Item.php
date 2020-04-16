<?php


namespace Jonassiewertsen\StatamicButik\Checkout;

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
     * The product the item does base on
     */
    public Product $product;

    /**
     * The quanitity of this item in the shopping cart
     */
    public Int $quantity;

    /**
     * Will return the total price of the item
     */
    private string $total;

    public function __construct(Product $product)
    {
        $this->id           = $product->slug;
        $this->name         = $product->title;
        $this->product      = $product;
        $this->quantity     = 1;
        $this->total        = $this->calculateTotalPrice();

    }

    public function increase()
    {
        $this->quantity++;
    }

    public function decrease()
    {
        if ($this->quantity === 1) {
            return;
        }

        $this->quantity--;
    }

    public function quantity($quanitity): void
    {
        $this->quantity = $quanitity;
        $this->calculateTotalPrice();
    }

    public function totalPrice(): string
    {
        return $this->total;
    }

    public function singlePrice(): string
    {
        return $this->product->totalPrice;
    }

    private function calculateTotalPrice() {
        $price       = $this->makeAmountSaveable($this->product->totalPrice);
        $this->total = $this->makeAmountHuman($price * $this->quantity);
        return $this->total;
    }
}
