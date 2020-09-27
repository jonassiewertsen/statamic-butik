<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Facades\Entry;

class ShippingByPriceTest extends TestCase
{
    use MoneyTrait;

    public Product $product1;
    public Product $product2;
    public Product $product3;

    public function setUp(): void
    {
        parent::setUp();

        $shippingProfile = create(ShippingProfile::class)->first();
        $shippingZone = create(ShippingZone::class)->first();

        $this->product1 = $this->makeProduct();
        $this->product2 = $this->makeProduct(['shipping_profile_slug' => $shippingProfile->slug]);
        $this->product3 = $this->makeProduct();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'title'            => 'Standard',
            'minimum'          => 0,
            'price'            => '6,00',
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'title'            => 'Free',
            'minimum'          => 50,
            'price'            => 0,
        ]);
    }

    /** @test */
    public function the_correct_total_item_value_will_be_calculated()
    {
        Cart::add($this->product1->slug);
        Cart::add($this->product2->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $total = $this->makeAmountSaveable($this->product1->price) + $this->makeAmountSaveable($this->product2->price);

        $this->assertEquals($total, $shipping->totalItemValue);
    }


    /** @test */
    public function the_standard_shipping_rate_will_be_selected()
    {
        $product = Entry::findBySlug($this->product1->slug, 'products');
        $product->set('price', '49.99')->save();

        Cart::add($this->product1->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('6,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_standard_shipping_rate_wont_be_used_if_the_amount_does_match()
    {
        $product = Entry::findBySlug($this->product1->slug, 'products');
        $product->set('price', '50.00')->save();

        Cart::add($this->product1->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_free_shipping_amount_will_be_calculated()
    {
        Cart::add($this->product1->slug);
        Cart::add($this->product2->slug);
        Cart::add($this->product3->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_cart_will_output_the_correct_amount()
    {
        $product = Entry::findBySlug($this->product1->slug, 'products');
        $product->set('price', '4.00')->save();

        Cart::add($this->product1->slug);
        $shipping = Cart::shipping();

        $this->assertEquals('6,00', $shipping->first()->total);
    }

    /** @test */
    public function the_cart_does_return_the_total_shipping_amount()
    {
        $product = Entry::findBySlug($this->product1->slug, 'products');
        $product->set('price', '4.00')->save();

        Cart::add($this->product1->slug);
        $total = Cart::totalShipping();

        $this->assertEquals('6,00', $total);
    }
}
