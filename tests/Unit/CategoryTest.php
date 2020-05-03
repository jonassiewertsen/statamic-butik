<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_is_available_as_default(){
        $category = create(Category::class)->first();

        $this->assertInstanceOf('Illuminate\Support\Collection', $category->products);
    }
}
