<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Helpers\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    protected Product $product;

    public function setUp(): void {
        parent::setUp();
        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function a_product_can_be_addes_as_item()
    {
        $this->assertNull(Session::get('butik.cart'));

        Cart::add($this->product);

        $this->assertCount(1, Cart::get());
    }

    /** @test */
    public function a_new_cart_item_has_the_quanitity_of_one()
    {
        Cart::add($this->product);

        $this->assertEquals(1, Cart::get()->first()->quantity);
    }

    /** @test */
    public function the_quanitity_will_be_increase_if_the_product_already_has_been_added()
    {
        Cart::add($this->product);
        $this->assertEquals(1, Cart::get()->first()->quantity);

        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->quantity);
    }

    /** @test */
    public function an_item_can_be_removed()
    {
        Cart::add($this->product);
        $this->assertTrue(Cart::get()->contains('id', $this->product->slug));

        Cart::reduce($this->product);
        $this->assertFalse(Cart::get()->contains('id', $this->product->slug));
    }

    /** @test */
    public function an_item_with_more_then_one_item_will_only_be_decreased()
    {
        Cart::add($this->product);
        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->quantity);

        Cart::reduce($this->product);
        $this->assertEquals(1, Cart::get()->first()->quantity);
    }

    /** @test */
    public function an_item_can_be_completly_removed()
    {
        Cart::add($this->product);
        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->quantity);

        Cart::remove($this->product);
        $this->assertFalse(Cart::get()->contains('id', $this->product->slug));
    }

    /** @test */
    public function the_cart_can_be_cleared()
    {
        Cart::add($this->product);
        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->quantity);

        Cart::clear();
        $this->assertTrue((Cart::get() == collect()));
    }
}
