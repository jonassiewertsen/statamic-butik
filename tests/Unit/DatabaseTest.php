<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function testing_the_database_with_the_product_table()
    {
        $product = raw(Product::class);
        Product::create($product);

        $this->assertDatabaseHas('products', $product);
    }
}
