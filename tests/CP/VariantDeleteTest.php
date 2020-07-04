<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class VariantDeleteTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_variant_can_be_deleted()
    {
        $variant = create(Variant::class)->first();
        $this->assertCount(1, Variant::all());

        $this->delete(cp_route('butik.variants.destroy', $variant));

        $this->assertCount(0, Variant::all());
    }

    /** @test */
    public function a_variant_will_be_deleted_if_the_parent_product_gets_deleted()
    {
        $variant = create(Variant::class)->first();
        $this->assertCount(1, Variant::all());

        $this->delete(cp_route('butik.products.destroy', Product::first()));

        $this->assertCount(0, Variant::all());
    }
}
