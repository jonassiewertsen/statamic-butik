<?php

namespace TestsCP;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Tests\TestCase;

class ShippingZoneCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_zone_can_be_created()
    {
        $shippingZone = raw(ShippingZone::class);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingZone::count());
    }

    /** @test */
    public function title_is_required()
    {
        $ShippingZone = raw(ShippingZone::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $ShippingZone)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function shipping_is_required()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => '']);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }

    /** @test */
    public function type_is_required()
    {
        $shippingZone = raw(ShippingZone::class, ['type' => '']);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('type');
    }

    /** @test */
    public function the_shipping_profile_relation_must_exist()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => 44]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }
}
