<?php

namespace Tests\Cart;

use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Cart\ItemCollection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Cart;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    protected ProductRepository $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
        $this->rawCart = [
            "qy3g8b" => [
                "quantity" => 1,
            ]
        ];
    }

    /** @test */
    public function it_has_a_slug()
    {
        Cart::add($this->product->slug);
        dd(Cart::get());

        $itemCollection (new ItemCollection())

        $item = new Item($this->product->slug);

        $this->assertEquals($item->slug, $this->product->slug);
    }
}
