<?php

namespace Jonassiewertsen\StatamicButik\Tests\Checkout;

use Illuminate\Support\Facades\Config;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

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
