<?php

namespace Jonassiewertsen\StatamicButik\Tests\Modifiers;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Modifiers\CountryName;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryNameTest extends TestCase
{
    /** @test */
    public function a_variant_can_be_added_as_item()
    {
        create(ShippingZone::class);

        $this->assertEquals(
            (new CountryName())->index(Country::get()),
            Country::list()->first()
        );
    }
}
