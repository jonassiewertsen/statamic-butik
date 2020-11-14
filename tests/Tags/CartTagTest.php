<?php

namespace Tests\Tags;

use Jonassiewertsen\StatamicButik\Checkout\Cart as ShoppingCart;
use Jonassiewertsen\StatamicButik\Tags\Cart;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTagTest extends TestCase
{
    public $cart;

    public function setUp(): void
    {
        parent::setUp();
        $this->cart = new Cart();
    }

    /** @test */
    public function it_will_return_the_bag()
    {
        $this->assertEquals(ShoppingCart::get(), $this->cart->index(), );
    }

    /** @test */
    public function it_will_return_the_bag_items()
    {
        $this->assertEquals(ShoppingCart::get(), $this->cart->items(), );
    }

    /** @test */
    public function it_will_return_the_toal_items()
    {
        $this->assertEquals(ShoppingCart::totalItems(), $this->cart->totalItems(), );
    }

    /** @test */
    public function it_will_return_the_toal_shipping()
    {
        $this->assertEquals(ShoppingCart::totalShipping(), $this->cart->totalShipping(), );
    }

    /** @test */
    public function it_will_return_the_toal_price()
    {
        $this->assertEquals(ShoppingCart::totalPrice(), $this->cart->totalPrice(), );
    }

    /** @test */
    public function it_will_return_the_total_taxes()
    {
        $this->assertEquals(ShoppingCart::totalTaxes(), $this->cart->totalTaxes());
    }
}
