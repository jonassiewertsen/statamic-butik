<?php

namespace Jonassiewertsen\Butik\Tests\Shop;

use Facades\Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Tests\TestCase;
use Statamic\Facades\Entry;

class ProductOverviewTest extends TestCase
{
    /** @test */
    public function the_shop_overview_page_does_exist()
    {
        $this->get(route('butik.shop'))
            ->assertOk();
    }

    /** @test */
    public function all_product_information_will_be_shown()
    {
        $product = $this->makeProduct();

        $this->get(route('butik.shop'))
            ->assertSee($product->title)
            ->assertSee($product->price)
            ->assertSee($product->show_url)
            ->assertDontSee('sold out');
    }

    /** @test */
    public function a_non_available_product_will_be_hidden()
    {
        $product = $this->makeProduct();

        $entry = Entry::findBySlug($product->slug, 'products');
        $entry->unpublish()->save();

        $product = Product::find($product->slug);

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

        $product = $this->makeProduct();

        $entry = Entry::findBySlug($product->slug, 'products');
        $entry->set('stock', 0)->save();

        $this->get(route('butik.shop'))->assertSee('Sold out');
    }

    /** @test */
    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
    {
        $product = $this->makeProduct();

        $entry = Entry::findBySlug($product->slug, 'products');
        $entry->set('stock', 0);
        $entry->set('stock_unlimited', true);
        $entry->save();

        $this->get(route('butik.shop'))->assertDontSee('Sold out');
    }
}
