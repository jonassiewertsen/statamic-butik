<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutDeliverTest extends TestCase
{
    /** @test */
    public function The_express_delivery_page_does_exist()
    {
        $product = create(Product::class)->first();

        $this->get(route('butik.checkout.express.delivery', $product))
            ->assertOk()
            ->assertSee('Express Checkout');
    }
}
