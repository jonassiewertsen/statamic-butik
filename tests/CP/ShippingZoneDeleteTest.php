<?php

namespace TestsCP;

use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Tests\TestCase;

class ShippingZoneDeleteTest extends TestCase
{
    /** @test */
    public function A_shipping_type_can_be_deleted()
    {
        $this->signInAdmin();

        $shippingZone = create(ShippingZone::class);
        $this->assertEquals(1, $shippingZone->count());

        $this->delete(route('statamic.cp.butik.shipping-zones.destroy', $shippingZone->first()))
            ->assertOk();

        $this->assertEquals(0, ShippingZone::count());
    }
}
