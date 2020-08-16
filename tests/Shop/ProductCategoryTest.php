<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    protected $product;
    protected $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = create(Product::class)->first();
        create(Category::class)->first();
        $this->category = Category::first();
    }

    /** @test */
    public function the_view_of_a_single_category_does_exist()
    {
        $this->withoutExceptionHandling();
        $this->get(route('butik.shop.category', $this->category))
            ->assertOk();
    }

    /** @test */
    public function without_any_products_a_description_will_be_shown()
    {
        $this->get(route('butik.shop.category', $this->category))
            ->assertSee(__('butik::web.no_proucts_available_in_this_category'));
    }

    /** @test */
    public function only_a_product_of_this_category_will_be_shown()
    {
        $this->category->addProduct($this->product);

        $this->get(route('butik.shop.category', $this->category))
            ->assertSee($this->product->name)
            ->assertSee($this->product->show_url);
    }
}
