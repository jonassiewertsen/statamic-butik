<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Shipping\Shipping;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTest extends TestCase
{
    protected Collection $cart;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = create(Product::class)->first();
        $country = create(Country::class)->first();
        $zone = create(ShippingZone::class)->first();
        $zone->addCountry($country);

        Config::set('butik.country', $country->slug);

        Cart::add($this->product->slug);
    }

    /** @test */
    public function the_default_country_is_defined_in_the_config_file()
    {
        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertEquals($shipping->country->name, Country::first()->name);
    }

    /** @test */
    public function the_default_country_will_be_found_as_well_if_written_in_lower_case()
    {
        $country = Country::first();
        Config::set('butik.country', Str::lower($country->name));

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertEquals($shipping->country->name,  $country->name);
    }

    /** @test */
    public function A_non_existing_country_will_throw_an_exception()
    {
        $this->expectException(ButikConfigException::class);
        Config::set('butik.country', 'not existing');

        $shipping = new Shipping(Cart::get());
        $shipping->handle();
    }

    /** @test */
    public function a_profile_from_the_item_will_be_collected_inside_the_profile_bag()
    {
        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertCount(1, $shipping->profiles);
        $this->assertEquals(ShippingProfile::first(), $shipping->profiles->first());
    }

    /** @test */
    public function multiple_profiles_will_be_deteced()
    {
        $product = create(Product::class)->first();
        Cart::add($product->slug);

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertCount(2, $shipping->profiles);
    }

    /** @test */
    public function the_same_shipping_profile_will_only_be_detected_once()
    {
        $profile = Cart::get()->first()->shippingProfile;

        $product = create(Product::class, ['shipping_profile_slug' => $profile['slug']])->first();
        Cart::add($product->slug);

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertCount(1, $shipping->profiles);
    }

    /** @test */
    public function if_a_profile_cant_detect_a_belonging_shipping_zone_the_items_will_be_declared_as_non_sellable()
    {
        Cart::setCountry(create(Country::class)->first()->name);

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        foreach ($shipping->items as $item) {
            $this->assertFalse($item->sellable);
        }
    }
}
