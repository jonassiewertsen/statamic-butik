<?php

namespace Tests\Tags;

use Jonassiewertsen\Butik\Tags\Butik;
use Tests\TestCase;

class ButikTagTest extends TestCase
{
    public $tag;

    public function setUp(): void
    {
        parent::setUp();
        $this->tag = new Butik();
    }

    /** @test */
    public function it_will_return_the_cart_route()
    {
        $this->assertEquals(route('butik.cart', [], false), $this->tag->cart());
    }

    /** @test */
    public function it_will_return_the_bag_route()
    {
        $this->assertEquals(route('butik.cart', [], false), $this->tag->bag());
    }

    /** @test */
    public function it_will_return_the_payment_path()
    {
        $this->assertEquals(route('butik.checkout.payment', [], false), $this->tag->payment());
    }
}
