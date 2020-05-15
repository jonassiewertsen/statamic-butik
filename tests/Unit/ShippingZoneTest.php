<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingZoneTest extends TestCase
{
    /** @test */
    public function it_has_a_shipping_profile()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $this->assertInstanceOf(ShippingProfile::class, $shippingZone->profile);
    }
}
