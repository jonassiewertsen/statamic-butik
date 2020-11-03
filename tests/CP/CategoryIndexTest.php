<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function to_a_product_belonging_categories_can_be_fetched()
    {
        $product  = $this->makeProduct();
        create(Category::class)->first();
        $category = Category::first();

        $category->fresh()->addProduct($product->slug);

        $this->get(cp_route('butik.categories.from-product', $product->slug))
            ->assertJsonFragment([
                'name'        => $category->name,
                'slug'        => $category->slug,
                'is_attached' => $category->isProductAttached($product->slug),
            ]);

    }
}
