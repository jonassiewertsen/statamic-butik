<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingDeleteTest extends TestCase
{
    /** @test */
    public function shippings_can_be_deleted()
    {
        $this->signInAdmin();

        $shipping = create(Shipping::class);
        $this->assertEquals(1, $shipping->count());

        $this->delete(route('statamic.cp.butik.shippings.destroy', $shipping->first()))
            ->assertOk();

        $this->assertEquals(0, Shipping::count());
    }
}
