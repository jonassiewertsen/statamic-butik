<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product as ProductModel;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryTest extends TestCase
{
    public ?ProductModel $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
    }

    /** @test */
    public function a_category_has_many_products()
    {
        $this->assertCount(0, Category::all());

        create(Category::class);
        $category = Category::first();
        $category->addProduct($this->product->slug);

        $this->assertCount(1, $category->products);
    }

    /** @test */
    public function it_is_available_as_default()
    {
        $category = create(Category::class)->first();

        $this->assertInstanceOf('Illuminate\Support\Collection', $category->products);
    }

    /** @test */
    public function it_can_be_attached_to_a_product()
    {
        create(Category::class);
        $category = Category::first();

        $this->assertFalse($category->isProductAttached($this->product->slug));

        $category->addProduct($this->product->slug);
        $this->assertTrue($category->isProductAttached($this->product->slug));
    }

    /** @test */
    public function it_can_be_detatched_to_a_product()
    {
        create(Category::class);
        $category = Category::first();
        $category->addProduct($this->product->slug);

        $this->assertTrue($category->isProductAttached($this->product->slug));

        $category->removeProduct($this->product->slug);
        $this->assertFalse($category->isProductAttached($this->product->slug));
    }

    /** @test */
    public function a_category_has_a_url()
    {
        create(Category::class);
        $category = Category::first();

        $this->assertEquals(route('butik.shop.category', $category, false), $category->url);
    }
}
