<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shop;

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
        $this->get(route('butik.shop.product', $this->product))
            ->assertOk()
            ->assertViewIs(config('butik.template_product-show'));
    }

    /** @test */
    public function product_information_will_be_shown()
    {
        $this->get(route('butik.shop.product', $this->product))
            ->assertSee($this->product->title)
            ->assertSee($this->product->description)
            ->assertSee($this->product->base_price)
            ->assertSee($this->product->total_price)
            ->assertSee($this->product->shippin_amount)
//            ->assertSee(__('butik::cart.add'))
            ->assertDontSee('sold out');
    }

    /** @test */
    public function a_product_must_be_available_to_be_shown()
    {
        $product = create(Product::class, ['available' => false])->first();

        $this->get(route('butik.shop.product', $product))
            ->assertRedirect(route('butik.shop'));
    }

    /** @test */
    public function a_product_out_of_stock_will_be_shown_as_sold_out()
    {
        $product = create(Product::class, ['stock' => 0])->first();
        $this->get(route('butik.shop.product', $product))
            ->assertSee(__('butik::product.sold_out'));
    }

    /** @test */
    public function a_product_out_of_stock_will_hide_the_express_checkout_button()
    {
        $product = create(Product::class, ['stock' => 0])->first();
        $this->get(route('butik.shop.product', $product))
            ->assertDontSee('Express Checkout');
    }

    /** @test */
    public function a_product_with_unlimted_stock_wont_be_shown_as_sold_out()
    {
        $product = create(Product::class, ['stock_unlimited' => true, 'stock' => 0])->first();

        $this->get(route('butik.shop.product', $product))
            ->assertDontSee('sold out');
    }
}
