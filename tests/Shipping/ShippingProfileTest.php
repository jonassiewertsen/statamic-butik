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
                'countries' => [$country_code],
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

        $shippingZone = create(ShippingZone::class)->first();
        $this->makeProduct([], $shippingZone);
        $this->delete(cp_route('butik.shipping-profiles.destroy', $shippingZone->profile));

        $this->assertDatabaseHas('butik_shipping_profiles', $shippingZone->profile->toArray());
    }

    /** @test */
    public function a_shipping_profile_has_multiple_countries()
    {
        $this->signInAdmin();

        $shippingProfile = $this->createZones();

        $this->assertEquals(
            ['DE', 'DK', 'EN'], // Make sure that GB is not included
            $shippingProfile->countries,
        );
    }

    private function createZones(): ShippingProfile
    {
        $shippingProfile = create(ShippingProfile::class)->first();

        // Belonging to shipping profile 1
        create(ShippingZone::class, [
            'shipping_profile_slug' => $shippingProfile->slug,
            'countries' => ['DE'],
        ]);

        // Belonging to shipping profile 1
        create(ShippingZone::class, [
            'shipping_profile_slug' => $shippingProfile->slug,
            'countries' => ['DK', 'EN'],
        ]);

        // Belonging to another shipping profile
        create(ShippingZone::class, [
            'countries' => ['GB'],
        ]);

        return $shippingProfile;
    }
}
