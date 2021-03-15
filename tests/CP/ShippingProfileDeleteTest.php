<?php

namespace Tests\CP;

use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Tests\TestCase;

class ShippingProfileDeleteTest extends TestCase
{
    /** @test */
    public function A_shipping_type_can_be_deleted()
    {
        $this->signInAdmin();

        $shippingProfile = create(ShippingProfile::class);
        $this->assertEquals(1, $shippingProfile->count());

        $this->delete(route('statamic.cp.butik.shipping-profiles.destroy', $shippingProfile->first()))
            ->assertOk();

        $this->assertEquals(0, ShippingProfile::count());
    }
}
