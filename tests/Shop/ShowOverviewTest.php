<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShowOverviewTest extends TestCase
{
    /** @test */
    public function The_shop_overview_page_does_exist()
    {
        $this->get(route('butik.shop'))
            ->assertOk()
            ->assertViewIs('statamic-butik::web.shop.index');
    }

    /** @test */
    public function all_product_information_will_be_shown()
    {
        $product = create(Product::class, [], 10)->first();

        $this->get(route('butik.shop'))
            ->assertSee($product->title);
//            ->assertSee($product->description)
//            ->assertSee($product->base_price);
    }
}
