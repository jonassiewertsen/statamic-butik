<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryUpdateTest extends TestCase
{
    public Category $category;

    public function setUp(): void
    {
        parent::setUp();

        create(Category::class)->first();
        $this->category = Category::first();

        $this->signInAdmin();
    }

    /** @test */
    public function a_title_can_be_updated()
    {
        $this->category->name = 'new name';
        $this->updateCategory();

        $this->assertDatabaseHas('butik_categories', ['name' => 'new name']);
    }

    private function updateCategory()
    {
        return $this->patch(cp_route('butik.categories.update', $this->category), $this->category->getAttributes());
    }
}
