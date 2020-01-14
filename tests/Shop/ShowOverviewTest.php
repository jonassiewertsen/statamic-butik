<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShowOverviewTest extends TestCase
{
    /** @test */
    public function The_shop_overview_page_does_exist()
    {
        create(Product::class, [], 10);
        $this->get(route('butik.shop'))->assertOk();

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.shop', route('butik.shop'));
        $this->assertStatamicTemplateIs('statamic-butik::web.shop.overview', route('butik.shop'));
    }

    /** @test */
    public function all_product_information_will_be_shown()
    {
        $product = create(Product::class, [], 10)->first();

        $this->get(route('butik.shop'))
            ->assertSee($product->title)
            ->assertSee($product->base_price);
    }
}
