<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
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
        $shippingProfile = create(ShippingProfile::class)->first();
        $country_code = 'ES';

        create(ShippingZone::class,
            [
                'shipping_profile_slug' => ShippingProfile::first()->slug,
                'countries' => [$country_code]
            ]
        );

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()
        ]);

        $this->assertEquals(ShippingZone::first(), $shippingProfile->whereZoneFrom($country_code));
    }
}
