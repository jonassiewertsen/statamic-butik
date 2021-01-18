<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Shipping\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTest extends TestCase
{
    protected Collection $cart;

    public function setUp(): void
    {
        parent::setUp();

        $country = Country::get();
        $shippingZone = create(ShippingZone::class, ['countries' => [$country]])->first();

        $this->product = $this->makeProduct([], $shippingZone, false);

        Config::set('butik.country', $country);

        Cart::add($this->product->slug);
    }

    /** @test */
    public function the_default_country_is_defined_in_the_config_file()
    {
        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertEquals($shipping->country, Country::get());
    }

    /** @test */
    public function the_default_country_will_be_found_as_well_if_written_in_lower_case()
    {
        $country = Country::get();
        Country::set($country);

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertEquals($shipping->country, $country);
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
        $product = $this->makeProduct(['shipping_profile_slug' => create(ShippingProfile::class)->first()->slug]);
        Cart::add($product->slug);

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        $this->assertCount(2, $shipping->profiles);
    }

    /** @test */
    public function the_same_shipping_profile_will_only_be_detected_once()
    {
        $profile = Cart::get()->first()->shippingProfile;
        $product = $this->makeProduct([], $profile->zones->first());
        Cart::add($product->slug);

        $shipping = new Shipping(Cart::get());

        $shipping->handle();

        $this->assertCount(1, $shipping->profiles);
    }

    /** @test */
    public function if_a_profile_cant_detect_a_belonging_shipping_zone_the_items_will_be_declared_as_non_sellable()
    {
        create(ShippingZone::class, ['countries' => ['DK']]);
        Cart::setCountry('DK');

        $shipping = new Shipping(Cart::get());
        $shipping->handle();

        foreach ($shipping->items as $item) {
            $this->assertFalse($item->sellable);
        }
    }
}
