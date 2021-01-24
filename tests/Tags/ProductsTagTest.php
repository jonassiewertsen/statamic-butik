<?php

namespace Tests\Tags;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tags\Products;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductsTagTest extends TestCase
{
    public $products;

    public function setUp(): void
    {
        parent::setUp();
        $this->products = new Products();
    }

    /** @test */
    public function it_will_return_all_products()
    {
        $this->assertEquals(Product::all()->toArray(), $this->products->index());
    }
}
