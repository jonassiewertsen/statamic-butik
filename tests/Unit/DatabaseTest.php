<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function testing_the_database_with_the_product_table()
    {
        $this->assertEquals(0, Product::count());

        $product = raw(Product::class);
        Product::create($product);

        $this->assertEquals(1, Product::count());
    }
}
