<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileTest extends TestCase
{
    /** @test */
    public function it_has_zones()
    {
        $shippingZone = create(ShippingProfile::class)->first();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shippingZone->zones);
    }

    /** @test */
    public function it_can_return_a_zone_to_a_specific_country()
    {
        $country = create(Country::class)->first();
        $shippingProfile = create(ShippingProfile::class)->first();
        create(ShippingZone::class,
            ['shipping_profile_slug' => ShippingProfile::first()->slug]
        );
        ShippingZone::first()->addCountry($country);

        $this->assertEquals(ShippingZone::first()->id, $shippingProfile->whereZoneFrom($country)->id);
    }
}
