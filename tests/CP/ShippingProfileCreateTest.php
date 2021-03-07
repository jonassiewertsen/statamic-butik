<?php

namespace TestsCP;

use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Tests\TestCase;

class ShippingProfileCreateTestCreateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function profiles_can_be_created()
    {
        $shippingProfile = raw(ShippingProfile::class);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingProfile)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingProfile::count());
    }

    /** @test */
    public function title_is_required()
    {
        $shippingProfile = raw(ShippingProfile::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingProfile)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function slug_is_required()
    {
        $shippingProfile = raw(ShippingProfile::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingProfile)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First shipping profile
        $shippingProfile = raw(ShippingProfile::class, ['slug' => $slug]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingProfile)
            ->assertSessionHasNoErrors();

        // Another shipping profile with the same slug
        $shippingProfile = raw(ShippingProfile::class, ['slug' => $slug]);
        $this->post(route('statamic.cp.butik.shipping-profiles.store'), $shippingProfile)
            ->assertSessionHasErrors('slug');
    }
}
