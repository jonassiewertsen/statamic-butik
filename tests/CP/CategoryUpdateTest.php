<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryUpdateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
        create(Category::class);
    }

    /** @test */
    public function the_name_can_be_updated()
    {
        $category = Category::first();
        $category->name = 'Updated Name';
        $this->updateCategory($category)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_categories', ['name' => 'Updated Name']);
    }

    /** @test */
    public function the_is_visible_can_be_updated()
    {
        $category = Category::first();
        $category->is_visible = false;
        $this->updateCategory($category)->assertSessionHasNoErrors();
        $this->assertFalse(Category::first()->is_visible);
    }

    private function updateCategory($category) {
        return $this->patch(route('statamic.cp.butik.categories.update', $category), $category->toArray());
    }
}
