<?php

namespace Tests\Tags;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Tags\Bag;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class BagTagTest extends TestCase
{
    public $bag;

    public function setUp(): void
    {
        parent::setUp();
        $this->bag = new Bag();
    }

   /** @test */
   public function it_will_return_the_bag()
   {
       $this->assertEquals(Cart::get(), $this->bag->index(),);
   }

    /** @test */
    public function it_will_return_the_bag_items()
    {
        $this->assertEquals(Cart::get(), $this->bag->items(),);
    }

    /** @test */
    public function it_will_return_the_toal_items()
    {
        $this->assertEquals(Cart::totalItems(), $this->bag->totalItems(),);
    }

    /** @test */
    public function it_will_return_the_toal_shipping()
    {
        $this->assertEquals(Cart::totalShipping(), $this->bag->totalShipping(),);
    }

    /** @test */
    public function it_will_return_the_toal_price()
    {
        $this->assertEquals(Cart::totalPrice(), $this->bag->totalPrice(),);
    }

    /** @test */
    public function it_will_return_the_total_taxes()
    {
        $this->assertEquals(Cart::totalTaxes(), $this->bag->totalTaxes());
    }
}
