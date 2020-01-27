<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductOverviewTest extends TestCase
{
    /** @test */
    public function The_shop_overview_page_does_exist()
    {
        create(Product::class, [], 10);
        $this->get(route('butik.shop'))->assertOk();

        $this->assertStatamicLayoutIs('butik::web.layouts.shop', route('butik.shop'));
        $this->assertStatamicTemplateIs('butik::web.shop.overview', route('butik.shop'));
    }

    /** @test */
    public function all_product_information_will_be_shown()
    {
        $product = create(Product::class, [], 10)->first();

        $this->get(route('butik.shop'))
            ->assertSee($product->title)
            ->assertSee($product->total_price)
            ->assertSee($product->show_url)
            ->assertDontSee('sold out');
    }

    /** @test */
    public function a_product_out_of_stock_will_be_shown_as_sold_out()
    {
        create(Product::class, ['stock' => 0])->first();
        $this->get(route('butik.shop'))->assertSee('sold out');
    }

    /** @test */
    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
    {
        create(Product::class, ['stock_unlimited' => true, 'stock' => 0])->first();
        $this->get(route('butik.shop'))->assertDontSee('sold out');
    }
}
