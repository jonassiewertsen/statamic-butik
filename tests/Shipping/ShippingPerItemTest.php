<?php

namespace Jonassiewertsen\Butik\Tests\Shipping;

use Jonassiewertsen\Butik\Checkout\Cart;
use Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Shipping\ShippingPerItem;
use Jonassiewertsen\Butik\Tests\TestCase;

class ShippingPerItemTest extends TestCase
{
    public Product $product1;
    public Product $product2;
    public Product $product3;

    public function setUp(): void
    {
        parent::setUp();

        $shippingProfile = create(ShippingProfile::class)->first();
        $shippingZone = create(ShippingZone::class, ['type' => 'per-item'])->first();

        $this->product1 = $this->makeProduct();
        $this->product2 = $this->makeProduct(['shipping_profile_slug' => $shippingProfile->slug]);
        $this->product3 = $this->makeProduct();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'title'            => 'Standard',
            'minimum'          => 0,
            'price'            => '15,00',
        ]);
    }

    /** @test */
    public function the_shipping_amount_will_be_added_to_a_single_item()
    {
        Cart::add($this->product1->slug);

        $shipping = new ShippingPerItem();
        $shipping->set(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $this->assertEquals('15,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_shipping_amount_will_be_double_if_two_items_will_be_shipped()
    {
        Cart::add($this->product1->slug);
        Cart::add($this->product1->slug);

        $shipping = new ShippingPerItem();
        $shipping->set(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $this->assertEquals('30,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_shipping_amount_will_be_doubled_with_two_different_items_as_well()
    {
        Cart::add($this->product1->slug);
        Cart::add($this->product2->slug);

        $shipping = new ShippingPerItem();
        $shipping->set(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $this->assertEquals('30,00', $shipping->calculate()->total);
    }
}
