<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class DeleteProductsTest extends TestCase
{
    /** @test */
    public function A_product_can_be_deleted()
    {
        $this->signIn();

        $product = create(Product::class);
        $this->assertEquals(1, $product->count());

        $this->delete(route('statamic.cp.butik.products.destroy', $product->first()))
            ->assertOk();

        $this->assertEquals(0, Product::count());
    }
}
