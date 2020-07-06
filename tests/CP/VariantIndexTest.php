<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class VariantIndexTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();

        create(Variant::class);
    }

    /** @test */
    public function a_variant_can_be_created()
    {
        $variant = Variant::first();
        $product = Product::first();

        $this->get(cp_route('butik.variants.index', $product))
            ->assertJsonFragment([
                'available'       => $variant->available,
                'title'           => $variant->title,
                'inherit_price'   => $variant->inherit_price,
                'price'           => $variant->price,
                'inherit_stock'   => $variant->inherit_stock,
                'stock'           => $variant->stock,
                'stock_unlimited' => $variant->stock_unlimited,
            ]);

    }
}
