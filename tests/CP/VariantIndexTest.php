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
    public function to_a_product_belonging_variants_can_be_fetched()
    {
        $variant = Variant::first();
        $product = Product::first();

        $this->get(cp_route('butik.variants.from-product', $product))
            ->assertJsonFragment([
                'id'              => $variant->id,
                'available'       => $variant->available,
                'title'           => $variant->original_title,
                'inherit_price'   => $variant->inherit_price,
                'price'           => $variant->original_price,
                'product_slug'    => $variant->product_slug,
                'inherit_stock'   => $variant->inherit_stock,
                'stock'           => $variant->original_stock,
                'stock_unlimited' => $variant->stock_unlimited,
            ]);

    }
}
