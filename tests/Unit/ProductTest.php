<?php

namespace Jonassiewertsen\Butik\Tests\Unit;

use Jonassiewertsen\Butik\Facades\Product;
use Jonassiewertsen\Butik\Tests\TestCase;

class ProductTest extends TestCase
{
    public $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function it_can_fetch_all_products()
    {
        $products = Product::all();

        $this->assertCount(1, $products);
    }

    /** @test */
    public function a_product_can_be_found()
    {
        $this->assertEquals($this->product, Product::find($this->product->id));
    }

    /** @test */
    public function a_product_can_be_found_by_its_slug()
    {
        $this->assertEquals($this->product, Product::findBySlug($this->product->slug));
    }
}
