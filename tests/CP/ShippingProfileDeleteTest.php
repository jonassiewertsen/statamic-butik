<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileDeleteTest extends TestCase
{
    /** @test */
    public function A_shipping_type_can_be_deleted()
    {
        $this->signInAdmin();

        $shippingType = create(ShippingProfile::class);
        $this->assertEquals(1, $shippingType->count());

        $this->delete(route('statamic.cp.butik.shipping-profiles.destroy', $shippingType->first()))
            ->assertOk();

        $this->assertEquals(0, ShippingProfile::count());
    }
}
