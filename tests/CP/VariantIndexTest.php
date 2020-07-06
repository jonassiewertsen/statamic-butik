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

        $this->get(cp_route('butik.variants.fromProduct', $product))
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
