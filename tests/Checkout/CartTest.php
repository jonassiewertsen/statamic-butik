<?php

namespace Tests\Checkout;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    protected Product   $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function the_cart_route_does_exist() {
        $this->withoutExceptionhandling();

        $this->get(route('butik.cart'))
            ->assertOk();
    }
//
//    /** @test */
//    public function the_cart_can_be_empty() {
//        $this->get(route('butik.cart'))
//            ->assertSee('Your shopping cart is empty.');
//    }
//
//    /** @test */
//    public function a_cart_item_can_be_added() {
//        $this->post(route('butik.cart.add', $this->product))
//            ->assertSessionHas('butik.cart');
//    }
//
//    /** @test */
//    public function items_from_the_session_will_be_added_to_the_cart() {
//        $items = collect();
//        $items->push(new Item(
//            create(Product::class)->first()
//        ));
//
//        Session::put('butik.cart', $items);
//        $cart = (new Cart)->get();
//
//        $this->assertEquals($items->first()->name, $cart->items->first()['name']);
//    }
//
//    /** @test */
//    public function a_cart_item_will_be_added_to_the_session() {
//        $this->assertFalse(Session::has('butik.cart'));
//
//        $this->post(route('butik.cart.add', $this->product));
//        $items = Session::get('butik.cart');
//
//        $this->assertEquals(
//            $items->first()->name,
//            $this->product->title
//        );
//    }
//
//    /** @test */
//    public function You_will_be_redirect_back_after_adding_the_item_to_you_cart() {
//        $this->get(route('butik.shop', $this->product));
//
//        $this->post(route('butik.cart.add', $this->product))
//            ->assertRedirect(back()->getTargetUrl());
//    }
}
