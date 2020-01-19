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

    public function setUp(): void {
        parent::setUp();
        $this->cart = new Cart();
    }

    // TODO: getId test

    /** @test */
    public function a_customer_can_be_added()
    {
        $this->cart->products(collect());
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->cart->products);
    }

    /** @test */
    public function a_transaction_can_be_added()
    {
        $this->cart->transaction(new Transaction());
        $this->assertInstanceOf(Transaction::class, $this->cart->transaction);
    }

    /** @test */
    public function products_can_be_added()
    {
        $products = create(Product::class, [], 3);

        $this->cart->products($products);
        $this->assertCount(3, $this->cart->products);
    }
}
