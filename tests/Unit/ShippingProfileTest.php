<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingProfileTest extends TestCase
{
    /** @test */
    public function it_has_zones()
    {
        $shippingZone = create(ShippingProfile::class)->first();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shippingZone->zones);
    }
}
