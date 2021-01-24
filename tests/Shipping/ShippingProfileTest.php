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

        create(
            ShippingZone::class,
            [
                'shipping_profile_slug' => ShippingProfile::first()->slug,
                'countries'             => [$country_code],
            ]
        );

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first(),
        ]);

        $this->assertEquals(ShippingZone::first(), $shippingProfile->whereZoneFrom($country_code));
    }

    /** @test */
    public function a_shipping_profile_can_be_deleted_if_no_product_is_related()
    {
        $this->signInAdmin();

        $shippingProfile = create(ShippingProfile::class)->first();
        $this->assertEquals(1, ShippingProfile::count());

        $this->delete(cp_route('butik.shipping-profiles.destroy', $shippingProfile));

        $this->assertEquals(0, ShippingProfile::count());
    }

    /** @test */
    public function a_shipping_profile_cant_be_deleted_if_a_product_is_related()
    {
        $this->signInAdmin();

        $shippingProfile = create(ShippingProfile::class)->first();
        $this->makeProduct(['shipping_profile_slug' => $shippingProfile->slug]);
        $this->delete(cp_route('butik.shipping-profiles.destroy', $shippingProfile));

        $this->assertDatabaseHas('butik_shipping_profiles', $shippingProfile->toArray());
    }
}
