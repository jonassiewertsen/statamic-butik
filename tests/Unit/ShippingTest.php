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

        $this->assertEquals(
            $shipping->editUrl(),
            '/'.config('statamic.cp.route')."/butik/shippings/{$shipping->slug}/edit"
            );
    }

    /** @test */
    public function it_has_products(){
        $shipping = create(Shipping::class)->first();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shipping->products);
    }
}
