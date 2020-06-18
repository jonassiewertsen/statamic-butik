<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxDeleteTest extends TestCase
{
    /** @test */
    public function taxes_can_be_deleted()
    {
        $this->signInAdmin();

        $tax = create(Tax::class);
        $this->assertEquals(1, $tax->count());

        $this->delete(route('statamic.cp.butik.taxes.destroy', $tax->first()))
            ->assertOk();

        $this->assertEquals(0, Tax::count());
    }

    /** @test */
    public function a_shipping_cant_be_deleted_if_it_related_to_any_existing_product()
    {
        $this->signInAdmin();

        $product = create(Product::class)->first();
        $this->assertEquals(1, $product->tax->count());

        $this->delete(route('statamic.cp.butik.taxes.destroy', $product->tax))
            ->assertStatus(403);

        $this->assertEquals(1, $product->tax->count());
    }
}
