<?php

namespace Tests\Unit;

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
    public function a_product_can_be_added()
    {
        $this->cart->add($this->product);
        $this->assertCount(1, $this->cart->items);
    }

    /** @test */
    public function a_new_cart_item_has_the_quanitity_of_one()
    {
        $this->cart->add($this->product);
        $this->assertEquals(1, $this->cart->items->first()->quanitity);
    }

}
