<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductShowTest extends TestCase
{
    protected $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function the_view_of_a_single_product_does_exist()
    {
        $route = route('butik.shop.product', $this->product);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.shop', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.shop.show', $route);
    }

    /** @test */
    public function product_information_will_be_shown()
    {
        $this->get(route('butik.shop.product', $this->product))
            ->assertSee($this->product->title)
            ->assertSee($this->product->description)
            ->assertSee($this->product->base_price);
    }
}
