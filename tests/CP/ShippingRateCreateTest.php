<?php

namespace TestsCP;

use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Tests\TestCase;

class ShippingRateCreateTestCreateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_rate_can_be_created()
    {
        $shippingRate = raw(ShippingRate::class);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingRate::count());
    }

    /** @test */
    public function title_is_required()
    {
        $shippingRate = raw(ShippingRate::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function price_is_required()
    {
        $shippingRate = raw(ShippingRate::class, ['price' => null]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('price');
    }

    /** @test */
    public function price_can_be_zero()
    {
        $shippingRate = raw(ShippingRate::class, ['price' => 0]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function minimum_is_required()
    {
        $shippingRate = raw(ShippingRate::class, ['minimum' => null]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('minimum');
    }

    /** @test */
    public function minimum_must_be_numeric()
    {
        $shippingRate = raw(ShippingRate::class, ['minimum' => 'three']);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('minimum');
    }

    /** @test */
    public function minimum_can_be_zero()
    {
        $shippingRate = raw(ShippingRate::class, ['minimum' => 0]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function minimum_cant_be_negative()
    {
        $shippingRate = raw(ShippingRate::class, ['minimum' => -1]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('minimum');
    }

    // TODO: Add ShippingRate type. At this moment we do only support rates with a price type

    /** @test */
    public function shipping_zone_id_is_required()
    {
        $shippingRate = raw(ShippingRate::class, ['shipping_zone_id' => null]);
        $this->post(route('statamic.cp.butik.shipping-rates.store'), $shippingRate)
            ->assertSessionHasErrors('shipping_zone_id');
    }
}
