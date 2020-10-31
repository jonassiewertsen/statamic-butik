<?php

namespace Jonassiewertsen\StatamicButik\Tests\Modifiers;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Modifiers\CountryName;
use Jonassiewertsen\StatamicButik\Shipping\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Modifiers\Modifier;

class CountryNameTest extends TestCase
{
    protected Modifier $modifier;

    public function setUp(): void
    {
        parent::setUp();

        $this->modifier = new CountryName();
    }

    /** @test */
    public function a_variant_can_be_added_as_item()
    {
        create(ShippingZone::class);

        $this->assertEquals(
            $this->modifier->index(Country::get()),
            Country::list()->first()
        );
    }
}
