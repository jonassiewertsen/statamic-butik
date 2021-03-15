<?php

namespace Tests\Modifiers;

use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Modifiers\CountryName;
use Jonassiewertsen\Butik\Shipping\Country;
use Statamic\Modifiers\Modifier;
use Tests\TestCase;

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
