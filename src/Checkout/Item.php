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
    public Int $quanitity;

    public function __construct(Product $product)
    {
//        $this->id             = $product->slug;
//        $this->name         = $product->name;
        $this->product      = $product;
        $this->quanitity    = 1;


    }
}
