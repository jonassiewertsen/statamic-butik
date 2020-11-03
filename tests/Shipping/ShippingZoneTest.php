<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingZoneTest extends TestCase
{
    /** @test */
    public function it_has_a_shipping_profile()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $this->assertInstanceOf(ShippingProfile::class, $shippingZone->profile);
    }

    /** @test */
    public function it_has_many_countries()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $this->assertInstanceOf('Illuminate\Support\Collection', $shippingZone->countries);
    }

    /** @test */
    public function it_has_many_rates()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shippingZone->rates);
    }

    /** @test */
    public function it_belongs_to_a_tax()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $this->assertInstanceOf(Tax::class, $shippingZone->tax);
    }
}
