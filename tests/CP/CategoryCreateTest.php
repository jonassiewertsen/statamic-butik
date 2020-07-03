<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function categories_can_be_created()
    {
        $category = raw(Category::class);
        $this->post(cp_route('butik.categories.store'), $category)->assertSessionHasNoErrors();
        $this->assertEquals(1, Category::count());
    }

    /** @test */
    public function name_is_required()
    {
        $category = raw(Category::class, ['name' => null]);
        $this->post(cp_route('butik.categories.store'), $category)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function slug_is_required()
    {
        $category = raw(Category::class, ['slug' => null]);
        $this->post(cp_route('butik.categories.store'), $category)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First category
        $category = raw(Category::class, ['slug' => $slug ]);
        $this->post(cp_route('butik.categories.store'), $category)
            ->assertSessionHasNoErrors();

        // Another category with the same slug
        $category = raw(Category::class, ['slug' => $slug ]);
        $this->post(cp_route('butik.categories.store'), $category)
            ->assertSessionHasErrors('slug');
    }
}
