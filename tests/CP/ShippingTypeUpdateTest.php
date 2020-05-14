<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingType;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTypeUpdateTest extends TestCase
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
        $shippingType = create(ShippingType::class)->first();
        $shippingType->title = 'Updated Name';
        $this->updateShippingType($shippingType)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_types', ['title' => 'Updated Name']);
    }

    private function updateShippingType($shippingType) {
        return $this->patch(route('statamic.cp.butik.shipping-types.update', $shippingType), $shippingType->toArray());
    }
}
