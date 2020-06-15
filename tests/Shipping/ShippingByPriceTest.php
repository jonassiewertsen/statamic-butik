<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Illuminate\Support\Facades\Config;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Shipping\ShippingByPrice;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingByPriceTest extends TestCase
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
        $this->product2 = create(Product::class, ['shipping_profile_slug' => ShippingProfile::first()->slug])->first();
        $this->product3 = create(Product::class)->first();

        $this->country = create(Country::class)->first();
        Config::set('butik.country', Country::first()->name);

        create(ShippingZone::class, [
            'shipping_profile_slug' => ShippingProfile::first()->slug,
        ]);

        ShippingZone::first()->addCountry($this->country);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()->id,
            'title'            => 'Standard',
            'minimum'          => 0,
            'price'            => 600,
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()->id,
            'title'            => 'Free',
            'minimum'          => 5000,
            'price'            => 0,
        ]);
    }

    /** @test */
    public function the_correct_total_item_value_will_be_calculated()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);

        $shipping = new ShippingByPrice(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $total = $this->makeAmountSaveable($this->product1->price) + $this->makeAmountSaveable($this->product2->price);

        $this->assertEquals($total, $shipping->totalItemValue);
    }


    /** @test */
    public function the_standard_shipping_rate_will_be_selected()
    {
        Cart::add(create(Product::class,
            ['price' => 49.99]
        )->first());

        $shipping = new ShippingByPrice(Cart::get(), ShippingZone::first());

        $this->assertEquals('6,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_standard_shipping_rate_wont_be_used_if_the_amount_does_match()
    {
        Cart::add(create(Product::class,
            ['price' => 50]
        )->first());

        $shipping = new ShippingByPrice(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_free_shipping_amount_will_be_calculated()
    {
        Cart::add($this->product1);
        Cart::add($this->product2);
        Cart::add($this->product3);

        $shipping = new ShippingByPrice(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_cart_will_output_the_correct_amount()
    {
        Cart::add(create(Product::class, [
            'shipping_profile_slug' => ShippingProfile::first()->slug,
            'price'                 => 4,
        ])->first());

        $shipping = Cart::shipping();

        $this->assertEquals('6,00', $shipping->first()->total);
    }

    /** @test */
    public function the_cart_does_return_the_total_shipping_amount()
    {
        Cart::add(create(Product::class, [
            'shipping_profile_slug' => ShippingProfile::first()->slug,
            'price'                 => 4,
        ])->first());

        $total = Cart::totalShipping();

        $this->assertEquals('6,00', $total);
    }
}
