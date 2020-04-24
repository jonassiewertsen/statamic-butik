<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Helper\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    use MoneyTrait;

    protected Product $product;

    public function setUp(): void {
        parent::setUp();
        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function a_product_can_be_added_as_item()
    {
        $this->assertNull(Session::get('butik.cart'));

        Cart::add($this->product);

        $this->assertCount(1, Cart::get());
    }

    /** @test */
    public function a_new_cart_item_has_the_quanitity_of_one()
    {
        Cart::add($this->product);

        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function the_quanitity_will_be_increase_if_the_product_already_has_been_added()
    {
        Cart::add($this->product);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());

        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());
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
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::reduce($this->product);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function an_item_can_be_completly_removed()
    {
        Cart::add($this->product);
        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::remove($this->product);
        $this->assertFalse(Cart::get()->contains('id', $this->product->slug));
    }

    /** @test */
    public function the_cart_can_be_cleared()
    {
        Cart::add($this->product);
        Cart::add($this->product);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::clear();
        $this->assertTrue((Cart::get() == collect()));
    }

    /** @test */
    public function the_cart_calculates_the_total_price()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1);
        Cart::add($product2);

        $item1 = Cart::get()->first();
        $item2 = Cart::get()->last();

        $calculatedPrice = $this->makeAmountSaveable($item1->totalPrice()) + $this->makeAmountSaveable($item2->totalPrice());
        $calculatedPrice = $this->makeAmountHuman($calculatedPrice);

        $this->assertEquals($calculatedPrice, Cart::totalPrice());
    }

    /** @test */
    public function the_cart_calculates_total_items()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1); // 1
        Cart::add($product1); // +1
        Cart::add($product2); // 2 + 1

        $this->assertEquals(3, Cart::totalItems());
    }

    /** @test */
    public function the_cart_calculates_total_shipping_expenses()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1);
        Cart::add($product2);

        $item1 = Cart::get()->first();
        $item2 = Cart::get()->last();

        $caluclatedShipping = $this->makeAmountSaveable($item1->totalShipping()) + $this->makeAmountSaveable($item2->totalShipping());
        $caluclatedShipping = $this->makeAmountHuman($caluclatedShipping);

        $this->assertEquals($caluclatedShipping, Cart::totalShipping());
    }
}
