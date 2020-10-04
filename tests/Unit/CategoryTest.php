<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Product as ProductModel;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Facades\Entry;

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

    /** @test */
    public function a_category_with_more_than_one_word_will_generate_a_proper_slug()
    {
        create(Category::class, ['slug' => 'outdoor plants']);
        $category = Category::first();

        $this->assertEquals('/shop/category/outdoor-plants', $category->url);
    }
}
