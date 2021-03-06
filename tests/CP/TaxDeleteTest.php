<?php

namespace Jonassiewertsen\Butik\Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Tax;
use Jonassiewertsen\Butik\Tests\TestCase;

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
    public function a_tax_cant_be_deleted_if_related_to_any_existing_product()
    {
        $this->signInAdmin();

        $product = $this->makeProduct();

        $this->delete(route('statamic.cp.butik.taxes.destroy', $product->tax))
            ->assertStatus(403);
    }
}
