<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductOverviewTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();
    }

    /** @test */
    public function the_shop_overview_page_does_exist()
    {
        $this->get(route('butik.shop'))
            ->assertOk();
    }

    /** @test */
    public function all_product_information_will_be_shown()
    {
        $product = create(Product::class)->first();

        $this->get(route('butik.shop'))
            ->assertSee($product->title)
            ->assertSee($product->price)
            ->assertSee($product->show_url)
            ->assertDontSee('sold out');
    }

    /** @test */
    public function a_non_available_product_will_be_hidden()
    {
        $product = create(Product::class,['available' => false])->first();

        $this->get(route('butik.shop'))
            ->assertDontSee($product->title)
            ->assertDontSee($product->price)
            ->assertDontSee($product->show_url);
    }

    /** @test */
    public function a_product_out_of_stock_will_be_shown_as_sold_out()
    {
        // Sold out products will only be shown on the overview type all.
        config()->set('butik.overview_type', 'all');

        create(Product::class, ['stock' => 0])->first();
        $this->get(route('butik.shop'))->assertSee('Sold out');
    }

    /** @test */
    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
    {
        create(Product::class, ['stock_unlimited' => true, 'stock' => 0])->first();
        $this->get(route('butik.shop'))->assertDontSee('Sold out');
    }
}
