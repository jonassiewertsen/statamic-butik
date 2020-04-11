<?php

namespace Tests\Checkout;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    protected Cart $cart;

    public function setUp(): void
    {
        parent::setUp();

//        $this->cart = (new Cart)->add((create(Product::class)->first()));
    }

    /** @test */
    public function the_cart_route_does_exist() {
        $this->withoutExceptionhandling();

        $this->get(route('butik.cart'))->assertOk();
    }
}
