<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CategoryTest extends TestCase
{
    public ?Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = create(Product::class)->first();
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

        $this->assertFalse($category->isProductAttached($this->product));

        $category->addProduct($this->product);
        $this->assertTrue($category->isProductAttached($this->product));
    }

    /** @test */
    public function it_can_be_detatched_to_a_product()
    {
        create(Category::class);
        $category = Category::first();
        $category->addProduct($this->product);

        $this->assertTrue($category->isProductAttached($this->product));

        $category->removeProduct($this->product);
        $this->assertFalse($category->isProductAttached($this->product));
    }
}
