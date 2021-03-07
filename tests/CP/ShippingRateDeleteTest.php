<?php

namespace TestsCP;

use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Tests\TestCase;

class ShippingRateDeleteTest extends TestCase
{
    /** @test */
    public function A_shipping_type_can_be_deleted()
    {
        $this->signInAdmin();

        $shippingRate = create(ShippingRate::class);
        $this->assertEquals(1, ShippingRate::count());

        $this->delete(route('statamic.cp.butik.shipping-rates.destroy', $shippingRate->first()))
            ->assertOk();

        $this->assertEquals(0, ShippingRate::count());
    }
}
