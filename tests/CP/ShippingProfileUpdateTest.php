<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileUpdateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

//    /** @test */
//    public function the_update_form_will_be_displayed()
//    {
//        $this->get(route('statamic.cp.butik.shippings.create'))
//            ->assertOK();
//    }

    /** @test */
    public function the_title_can_be_updated()
    {
        $shippingProfile = create(ShippingProfile::class)->first();
        $shippingProfile->title = 'Updated Name';
        $this->updateShippingProfile($shippingProfile)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_profiles', ['title' => 'Updated Name']);
    }

    private function updateShippingProfile($shippingProfile) {
        return $this->patch(route('statamic.cp.butik.shipping-profiles.update', $shippingProfile), $shippingProfile->toArray());
    }
}
