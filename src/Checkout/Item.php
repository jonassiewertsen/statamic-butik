<?php


namespace Jonassiewertsen\StatamicButik\Checkout;


use Jonassiewertsen\StatamicButik\Http\Models\Product;

class Item
{
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

    public function __construct(Product $product)
    {
        $this->id           = $product->slug;
        $this->name         = $product->title;
        $this->product      = $product;
        $this->quantity     = 1;
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
}