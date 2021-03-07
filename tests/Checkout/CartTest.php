<?php

namespace TestsCheckout;

use Jonassiewertsen\Butik\Http\Models\Product;
use Tests\TestCase;

class CartTest extends TestCase
{
    protected Product   $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
    }

    /** @test */
    public function the_cart_route_does_exist()
    {
        $this->get(route('butik.cart'))
            ->assertOk();
    }
}
