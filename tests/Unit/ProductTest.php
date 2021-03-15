<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Exceptions\ButikProductException;
use Jonassiewertsen\Butik\Facades\Product;
use Tests\TestCase;

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

    /** @test */
    public function a_product_has_a_stock()
    {
        $this->assertEquals((int) $this->product->data['stock'], $this->product->stock);
    }

    /** @test */
    public function a_product_stock_can_be_unlimited()
    {
        $this->assertEquals($this->product->data['stock_unlimited'], $this->product->stockUnlimited);
        $this->assertFalse($this->product->stock_unlimited);
    }

    /** @test */
    public function a_single_product_can_be_deleted()
    {
        $this->assertCount(1, Product::all());

        $product = Product::all()->first();
        $product->delete();

        $this->assertCount(0, Product::all());
    }

    /** @test */
    public function a_specific_product_can_be_deleted_from_the_collection()
    {
        $this->assertCount(1, Product::all());

        Product::delete($this->product->id);

        $this->assertCount(0, Product::all());
    }

    /** @test */
    public function a_not_found_product_cant_be_deleted_and_will_throw_an_exception()
    {
        $this->expectException(ButikProductException::class);

        Product::delete('not existing');

        $this->assertCount(0, Product::all());
    }
}
