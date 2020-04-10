<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    protected Cart $cart;
    protected Product $product;

    public function setUp(): void {
        parent::setUp();
        $this->cart = new Cart();
        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function a_customer_can_be_added()
    {
        $this->cart->customer(new Customer());
        $this->assertInstanceOf(Customer::class, $this->cart->customer);
    }

    /** @test */
    public function a_transaction_can_be_added()
    {
        $this->cart->transaction(new Transaction());
        $this->assertInstanceOf(Transaction::class, $this->cart->transaction);
    }

    /** @test */
    public function a_product_will_be_addes_as_item()
    {
        $this->cart->add($this->product);
        $this->assertCount(1, $this->cart->items);
    }

    /** @test */
    public function a_new_cart_item_has_the_quanitity_of_one()
    {
        $this->cart->add($this->product);
        $this->assertEquals(1, $this->cart->items->first()->quantity);
    }

    /** @test */
    public function an_new_item_will_be_added_to_the_session()
    {
        $this->cart->add($this->product);

        $fromSession = Session::get('butik.cart');

        $this->assertEquals(
            $fromSession->items->first(),
            $this->cart->items->first()
        );
    }

    /** @test */
    public function the_quanitity_will_be_increase_if_the_product_already_has_been_added()
    {
        $this->cart->add($this->product);
        $this->assertEquals(1, $this->cart->items->first()->quantity);

        $this->cart->add($this->product);
        $this->assertEquals(2, $this->cart->items->first()->quantity);
    }

    /** @test */
    public function an_item_can_be_removed()
    {
        $this->cart->add($this->product);

        $fromSession = Session::get('butik.cart');

        $this->cart->remove($this->product);
        $this->assertFalse($fromSession->items->contains('id', $this->product->slug));
    }
}
