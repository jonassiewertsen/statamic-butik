<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileCreateTestCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function profiles_can_be_created()
    {
        $country = raw(ShippingProfile::class);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $country)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingProfile::count());
    }

    /** @test */
    public function title_is_required()
    {
        $shippingType = raw(ShippingProfile::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingType)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function slug_is_required()
    {
        $shippingType = raw(ShippingProfile::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingType)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First country
        $country = raw(ShippingProfile::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $country)
            ->assertSessionHasNoErrors();

        // Another country with the same slug
        $country = raw(ShippingProfile::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $country)
            ->assertSessionHasErrors('slug');
    }
}
