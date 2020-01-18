<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingUpdateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

//    TODO: Add test back in again, if composer test has been resolved
//    /** @test */
//    public function the_update_form_will_be_displayed()
//    {
//        $this->get(route('statamic.cp.butik.shippings.create'))
//            ->assertOK();
//    }

    /** @test */
    public function the_title_can_be_updated()
    {
        $shipping = create(Shipping::class)->first();
        $shipping->title = 'Updated Name';
        $this->updateShipping($shipping)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('shippings', ['title' => 'Updated Name']);
    }

    /** @test */
    public function the_price_can_be_updated()
    {
        $shipping = create(Shipping::class)->first();
        $shipping->price = 99;
        $this->updateShipping($shipping);
        $this->assertDatabaseHas('shippings', ['price' => 99]);
    }

    private function updateShipping($shipping) {
        return $this->patch(route('statamic.cp.butik.shippings.update', $shipping), $shipping->toArray());
    }
}
