<?php

namespace Tests\CP;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingZoneCreateTestCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
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
    public function slug_is_required()
    {
        $ShippingZone = raw(ShippingZone::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $ShippingZone)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First shipping zone
        $shippingZone = raw(ShippingZone::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasNoErrors();

        // Another shipping zone with the same slug
        $shippingZone = raw(ShippingZone::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function shipping_is_required()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => '']);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }

    /** @test */
    public function shipping_relation_must_exist_required()
    {
        $shippingZone = raw(ShippingZone::class, ['shipping_profile_slug' => 44]);
        $this->post(route('statamic.cp.butik.shipping-zones.store'), $shippingZone)
            ->assertSessionHasErrors('shipping_profile_slug');
    }
}
