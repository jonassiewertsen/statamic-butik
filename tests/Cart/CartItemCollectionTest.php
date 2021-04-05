<?php

namespace Tests\Cart;

use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Cart\ItemCollection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Cart;
use Tests\TestCase;

class CartItemCollectionTest extends TestCase
{
    public ProductRepository $product;
    public Item $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->makeTax();
        $this->product = $this->makeProduct();
        Cart::add($this->product->slug);
    }

    /** @test */
    public function items_will_get_mapped_as_cart_items()
    {
        $collection = new ItemCollection(Cart::raw());

        $this->assertInstanceOf(Item::class, $collection->first());
    }
}
