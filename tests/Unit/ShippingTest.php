<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTest extends TestCase
{
    /** @test */
    public function shippings_have_a_edit_url()
    {
        $shipping = create(Shipping::class)->first();

        $this->assertStringContainsString(
            $shipping->editUrl(),
            cp_route('butik.shippings.edit', $shipping)
        );
    }

    /** @test */
    public function it_has_products(){
        $shipping = create(Shipping::class)->first();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shipping->products);
    }
}
