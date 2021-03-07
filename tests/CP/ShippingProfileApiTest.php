<?php

namespace TestsCP;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Tests\TestCase;

class ShippingProfileApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        create(ShippingProfile::class, [], 3);

        $this->signInAdmin();
    }

    /** @test */
    public function shipping_profiles_can_be_fetched()
    {
        $shippingProfiles = ShippingProfile::all()->map(function ($shipping) {
            return [
                'title' => $shipping->title,
                'slug'  => $shipping->slug,
            ];
        });

        $this->get(route('statamic.cp.butik.shipping-profiles.index'))
            ->assertJsonFragment($shippingProfiles->first());
    }

    /** @test */
    public function a_specific_profile_can_be_fetched()
    {
        $this->withoutExceptionHandling();
        $profile = ShippingProfile::first();
        create(ShippingZone::class, ['shipping_profile_slug' => $profile->slug])->first();
        create(ShippingRate::class, ['shipping_zone_id' => 1])->first();

        $shippingProfile = [
            'title'     => $profile->title,
            'slug'      => $profile->slug,
        ];

        $this->get(route('statamic.cp.butik.shipping-profiles.show', [
            'shipping_profile' => $shippingProfile['slug'],
        ]))->assertJsonFragment($shippingProfile);
    }
}
