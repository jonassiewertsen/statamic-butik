<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryDeleteTest extends TestCase
{
    /** @test */
    public function A_category_can_be_deleted()
    {
        $this->signInAdmin();

        create(Category::class);

        $category = Category::first();
        $this->assertEquals(1, $category->count());

        $this->delete(route('statamic.cp.butik.categories.destroy', $category->first()))
            ->assertOk();

        $this->assertEquals(0, Category::count());
    }
}
