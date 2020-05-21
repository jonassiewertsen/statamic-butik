<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingRateUpdateTest extends TestCase
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
        $shippingRate = create(ShippingRate::class)->first();
        $shippingRate->title = 'Updated Name';
        $this->updateShippingRate($shippingRate)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_rates', ['title' => 'Updated Name']);
    }

    /** @test */
    public function the_price_can_be_updated()
    {
        $shippingRate = create(ShippingRate::class)->first();
        $shippingRate->price = 99999;
        $this->updateShippingRate($shippingRate)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_rates', ['price' => '99999']);
    }

    /** @test */
    public function the_minimum_can_be_updated()
    {
        $shippingRate = create(ShippingRate::class)->first();
        $shippingRate->minimum = 99999;
        $this->updateShippingRate($shippingRate)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_rates', ['minimum' => '99999']);
    }

    /** @test */
    public function the_maximum_can_be_updated()
    {
        $shippingRate = create(ShippingRate::class)->first();
        $shippingRate->maximum = 99999;
        $this->updateShippingRate($shippingRate)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_shipping_rates', ['maximum' => '99999']);
    }

    private function updateShippingRate($shippingRate) {
        return $this->patch(route('statamic.cp.butik.shipping-rates.update', $shippingRate), $shippingRate->toArray());
    }
}
