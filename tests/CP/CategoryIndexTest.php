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

        create(Category::class);
        create(Product::class);
    }

    /** @test */
    public function to_a_product_belonging_categories_can_be_fetched()
    {
        $product  = Product::first();
        $category = Category::first();
        $category->addProduct($product);

        $this->get(cp_route('butik.categories.from-product', $product))
            ->assertJsonFragment([
                'name'        => $category->name,
                'slug'        => $category->slug,
                'is_attached' => $category->isProductAttached($product),
            ]);

    }
}
