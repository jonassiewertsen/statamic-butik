<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Livewire\Livewire;

class ProductOverviewTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        create(Product::class, [], 10);
    }

    /** @test */
    public function the_shop_overview_page_does_exist()
    {
        $this->get(route('butik.shop'))
            ->assertOk();
    }

    /** @test */
    public function a_product_without_variant_will_keep_its_expected_route()
    {
        $product = Product::first();
        $this->get($product->show_url)->assertOk();
    }

    /** @test */
    public function a_product_with_variant_will_be_redirected_to_the_variant_url()
    {
        $product = Product::first();
        $variant = create(Variant::class, ['product_slug' => $product->slug])->first();
        $this->get($product->show_url)->assertRedirect($variant->show_url);
    }

    /** @test */
    public function a_variant_with_a_not_existing_url_will_be_redirect_to_an_existing_one()
    {
        $product = Product::first();
        $variant = create(Variant::class, ['product_slug' => $product->slug])->first();
        $this->get($product->show_url . '/not-exsisting-variant')->assertRedirect($variant->show_url);
    }

    /** @test */
    public function a_product_without_a_variant_will_be_redirect_to_its_base_url()
    {
        $product = Product::first();
        $this->get($product->show_url . '/not-exsisting-variant')->assertRedirect($product->show_url);
    }

//      TODO: Get tests up and running with Livewire
//    /** @test */
//    public function all_product_information_will_be_shown()
//    {
//        $product = create(Product::class, [], 10)->first();
//
//        Livewire::test(Shop::class)
//            ->assertSee($product->total_price)
//            ->assertSee($product->show_url)
//            ->assertDontSee('sold out');
//    }

//    /** @test */
//    public function a_product_out_of_stock_will_be_shown_as_sold_out()
//    {
//        create(Product::class, ['stock' => 0])->first();
//        $this->get(route('butik.shop'))->assertSee('sold out');
//    }
//
//    /** @test */
//    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
//    {
//        create(Product::class, ['stock_unlimited' => true, 'stock' => 0])->first();
//        $this->get(route('butik.shop'))->assertDontSee('sold out');
//    }
}
