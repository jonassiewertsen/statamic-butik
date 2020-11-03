<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class DatabaseTest extends TestCase
{
    /** @test */
    public function testing_the_database_with_the_product_table()
    {
        $this->assertEquals(0, Category::count());

        $category = raw(Category::class);
        Category::create($category);

        $this->assertEquals(1, Category::count());
    }
}
