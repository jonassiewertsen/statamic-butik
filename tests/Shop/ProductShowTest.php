<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shop;

use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Facades\Entry;

class ProductShowTest extends TestCase
{
    protected $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function the_view_of_a_single_product_does_exist()
    {
        $this->get(route('butik.shop.product', $this->product->slug))
            ->assertOk();
    }

    /** @test */
    public function a_product_without_variant_will_keep_its_expected_route()
    {
        $this->get($this->product->show_url)->assertOk();
    }

    /** @test */
    public function a_product_with_variant_will_be_redirected_to_the_variant_url()
    {
        $variant = create(Variant::class, ['product_slug' => $this->product->slug])->first();
        $this->get($this->product->show_url)->assertRedirect($variant->show_url);
    }

    /** @test */
    public function a_variant_with_a_not_existing_url_will_be_redirect_to_an_existing_one()
    {
        $variant = create(Variant::class, ['product_slug' => $this->product->slug])->first();
        $this->get($this->product->show_url.'/not-exsisting-variant')->assertRedirect($variant->show_url);
    }

    /** @test */
    public function a_product_without_a_variant_will_be_redirect_to_its_base_url()
    {
        $this->get($this->product->show_url.'/not-exsisting-variant')->assertRedirect($this->product->show_url);
    }

    // Not testable with livewire
//    /** @test */
//    public function product_information_will_be_shown()
//    {
//        $this->get(route('butik.shop.product', $this->product))
//            ->assertSee($this->product->title)
//            ->assertSee($this->product->description)
//            ->assertSee($this->product->base_price)
//            ->assertSee($this->product->total_price)
//            ->assertSee($this->product->shippin_amount)
//            ->assertDontSee('Sold out');
//    }

    /** @test */
    public function a_product_must_be_available_to_be_shown()
    {
        $entry = Entry::findBySlug($this->product->slug, 'products');
        $entry->unpublish()->save();

        $this->get(route('butik.shop.product', $this->product->slug))
            ->assertRedirect(route('butik.shop'));
    }

    // Not testable with livewire
//    /** @test */
//    public function a_product_out_of_stock_will_be_shown_as_sold_out()
//    {
//        $product = create(Product::class, ['stock' => 0])->first();
//        $this->get(route('butik.shop.product', $product))
//            ->assertSee(__('butik::product.sold_out'));
//    }
//
//    /** @test */
//    public function a_product_out_of_stock_will_hide_the_express_checkout_button()
//    {
//        $product = create(Product::class, ['stock' => 0])->first();
//        $this->get(route('butik.shop.product', $product))
//            ->assertDontSee('Express Checkout');
//    }

    /** @test */
    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
    {
        $entry = Entry::findBySlug($this->product->slug, 'products');
        $entry->set('stock', 0);
        $entry->set('stock_unlimited', true);
        $entry->save();

        $this->get(route('butik.shop.product', $this->product->slug))
            ->assertDontSee('sold out');
    }
}
