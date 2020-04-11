<?php

namespace Tests\Checkout;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    protected Cart      $cart;
    protected Product   $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function the_cart_route_does_exist() {
        $this->get(route('butik.cart'))
            ->assertOk()
            ->assertSee('Shopping cart');
    }

    /** @test */
    public function the_cart_can_be_empty() {
        $this->get(route('butik.cart'))
            ->assertSee('Your shopping cart is empty.');
    }

    /** @test */
    public function a_cart_item_can_be_added() {
        $this->post(route('butik.cart.add', $this->product))
            ->assertSessionHas('butik.cart');
    }

    /** @test */
    public function a_cart_item_will_be_added_to_the_session() {
        $this->post(route('butik.cart.add', $this->product));

        $cart = Session::get('butik.cart');

        $this->assertEquals(
            $cart->items->first()->name,
            $this->product->title
        );
    }

    /** @test */
    public function You_will_be_redirect_back_after_adding_the_item_to_you_cart() {
        $this->get(route('butik.shop', $this->product));

        $this->post(route('butik.cart.add', $this->product))
            ->assertRedirect(back()->getTargetUrl());
    }
}
