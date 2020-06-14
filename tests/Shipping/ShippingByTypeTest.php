<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingByTypeTest extends TestCase
{
    use MoneyTrait;

    public Country $country;
    public Product $product1;
    public Product $product2;
    public Product $product3;

    public function setUp(): void
    {
        parent::setUp();

        $this->product1 = create(Product::class)->first();
        $this->product2 = create(Product::class, ['shipping_profile_slug' => ShippingProfile::first()->slug,])->first();
        $this->product3 = create(Product::class)->first();

        $this->country = create(Country::class)->first();

        create(ShippingZone::class, [
            'shipping_profile_slug' => ShippingProfile::first()->slug,
        ]);

        ShippingZone::first()->addCountry($this->country);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()->id,
            'title'            => 'Standard',
            'price'            => 600,
            'minimum'          => 0,
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()->id,
            'title'            => 'Free',
            'price'            => 0,
            'minimum'          => 5000,
        ]);
    }

    /** @test */
    public function the_total_item_value_will_only_include_items_from_the_passed_shipping_profile()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);
        Cart::add($this->product3);

        $shipping = new ShippingByPrice(
            ShippingProfile::first(),
            Cart::get(),
            $this->country
        );
        $shipping->calculate();

        $total = $this->makeAmountSaveable($this->product1->price) + $this->makeAmountSaveable($this->product2->price);

        $this->assertCount(2, $shipping->items);
        $this->assertEquals($total, $shipping->totalItemValue);
    }

    /** @test */
    public function the_correct_zone_will_be_detected()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);
        Cart::add($this->product3);

        $shipping = new ShippingByPrice(
            ShippingProfile::first(),
            Cart::get(),
            $this->country
        );
        $shipping->calculate();

        $this->assertEquals(ShippingZone::first()->id, $shipping->zone->id);
    }

    /** @test */
    public function the_standard_shipping_rate_will_be_selected()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);
        Cart::add($this->product3);

        $shipping = new ShippingByPrice(
            ShippingProfile::first(),
            Cart::get(),
            $this->country
        );
        $shipping->calculate();

        $this->assertEquals(ShippingRate::firstWhere('title', 'Standard')->id, $shipping->rate->id);
    }

    /** @test */
    public function the_correct_shipping_amount_will_be_calculated()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);
        Cart::add($this->product3);

        $shipping = new ShippingByPrice(
            ShippingProfile::first(),
            Cart::get(),
            $this->country
        );

        $this->assertEquals(600, $shipping->calculate());
    }
}
