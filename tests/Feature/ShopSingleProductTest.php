<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShopSingleProductTest extends TestCase
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
        $this->get(route('butik.shop.product', $this->product))
            ->assertOk()
            ->assertViewIs('statamic-butik::web.shop.show');
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
