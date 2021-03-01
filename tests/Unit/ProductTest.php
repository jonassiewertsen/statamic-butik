<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Facades\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

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
}
