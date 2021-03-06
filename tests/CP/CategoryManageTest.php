<?php

namespace Jonassiewertsen\Butik\Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Category;
use Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Tests\TestCase;

class CategoryManageTest extends TestCase
{
    protected Product $product;
    protected Category $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();

        create(Category::class);
        $this->category = Category::first();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function a_product_can_be_attachted_to_a_category()
    {
        $this->post(cp_route('butik.category.attach-product', [
            'category' => $this->category,
            'product'  => $this->product->slug,
        ]));

        $this->assertCount(1, $this->product->categories);
    }

    /** @test */
    public function a_product_can_be_detached_to__categoryt()
    {
        $this->category->addProduct($this->product->slug);
        $this->assertCount(1, $this->product->categories);

        $this->delete(cp_route('butik.category.attach-product', [
            'category' => $this->category,
            'product'  => $this->product->slug,
        ]));

        $this->assertCount(0, $this->product->categories);
    }
}
