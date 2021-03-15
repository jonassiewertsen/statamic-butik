<?php

namespace Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Variant;
use Tests\TestCase;

class VariantIndexTest extends TestCase
{
    /** @test */
    public function to_a_product_belonging_variants_can_be_fetched()
    {
        $this->signInAdmin();

        $product = $this->makeProduct();
        create(Variant::class, ['product_slug' => $product->slug]);
        $variant = Variant::first();

        $this->get(cp_route('butik.variants.from-product', $product->slug))
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
