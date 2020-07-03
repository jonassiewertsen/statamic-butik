<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryManageTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();

        create(Product::class);
        create(Category::class);
    }

    /** @test */
    public function a_product_can_be_attachted_to_a_category()
    {
        $this->post(cp_route('butik.category.attach-product', [
            'category' => Category::first(),
            'product'  => Product::first(),
        ]));

        $this->assertCount(1, Product::first()->categories);
    }

    /** @test */
    public function a_product_can_be_detached_to__categoryt()
    {
        $product  = Product::first();
        $category = Category::first();

        $category->addProduct($product);
        $this->assertCount(1, $product->categories);

        $this->delete(cp_route('butik.category.attach-product', [
            'category' => $category,
            'product'  => $product,
        ]));

        $this->assertCount(0, $product->fresh()->categories);
    }
}
