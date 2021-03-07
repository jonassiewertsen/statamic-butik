<?php

namespace TestsCP;

use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Tests\TestCase;

class ShippingZoneUpdateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

//    /** @test */
//    public function the_update_form_will_be_displayed()
//    {
//        $this->get(route('statamic.cp.butik.shippings.create'))
//            ->assertOK();
//    }

    /** @test */
    public function the_title_can_be_updated()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $shippingZone->title = 'Updated Name';
        $this->updateShippingZone($shippingZone)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_zones', ['title' => 'Updated Name']);
    }

    /** @test */
    public function the_shipping_profile_can_be_updated()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $shippingZone->shipping_profile_slug = create(ShippingProfile::class)->first()->slug;
        $this->updateShippingZone($shippingZone)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_zones', ['shipping_profile_slug' => $shippingZone->shipping_profile_slug]);
    }

    private function updateShippingZone($shippingZone)
    {
        return $this->patch(route('statamic.cp.butik.shipping-zones.update', $shippingZone), $shippingZone->toArray());
    }
}
