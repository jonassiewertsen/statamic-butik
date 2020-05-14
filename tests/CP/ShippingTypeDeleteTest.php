<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingType;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTypeDeleteTest extends TestCase
{
    /** @test */
    public function A_shipping_type_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $shippingType = create(ShippingType::class);
        $this->assertEquals(1, $shippingType->count());

        $this->delete(route('statamic.cp.butik.shipping-types.destroy', $shippingType->first()))
            ->assertOk();

        $this->assertEquals(0, ShippingType::count());
    }
}
