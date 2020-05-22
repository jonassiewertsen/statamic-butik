<?php

namespace Tests\CP;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        create(ShippingProfile::class, [], 3);

        $this->signInAdmin();
    }

    /** @test */
    public function shipping_profiles_can_be_fetched()
    {
        $shippingProfile = ShippingProfile::all()->map(function($shipping) {
            return [
                'slug' => $shipping->slug,
                'title' => $shipping->title,
            ];
        });

        $this->get(route('statamic.cp.butik.shipping-profiles.index'))
            ->assertJsonFragment($shippingProfile->first());
    }
}
