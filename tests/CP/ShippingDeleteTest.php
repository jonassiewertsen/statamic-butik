<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingDeleteTest extends TestCase
{
    /** @test */
    public function shippings_can_be_deleted()
    {
        $this->signInAdmin();

        $shipping = create(Shipping::class);
        $this->assertEquals(1, $shipping->count());

        $this->delete(route('statamic.cp.butik.shippings.destroy', $shipping->first()))
            ->assertOk();

        $this->assertEquals(0, Shipping::count());
    }

    /** @test */
    public function a_shipping_cant_be_deleted_if_it_related_to_any_existing_product()
    {
        $this->withoutExceptionHandling();
        $this->signInAdmin();

        $product = create(Product::class)->first();
        $this->assertEquals(1, $product->shipping->count());

        $this->delete(route('statamic.cp.butik.shippings.destroy', $product->shipping))
            ->assertStatus(403);

        $this->assertEquals(1, $product->shipping->count());
    }
}
