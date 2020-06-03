<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryTest extends TestCase
{
    public $country;

    public function setUp(): void {
        parent::setUp();

        $this->country = create(Country::class)->first();
    }

    /** @test */
    public function it_has_a_edit_url()
    {
        $this->assertEquals(
            $this->country->editUrl,
            '/'.config('statamic.cp.route')."/butik/settings/countries/{$this->country->slug}/edit"
            );
    }

    /** @test */
    public function a_country_can_be_in_the_zone()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $shippingZone->addCountry($this->country);

        $this->assertTrue($this->country->inCurrentZone($shippingZone));
        $this->assertFalse($this->country->inCurrentZone(create(ShippingZone::class)->first()));
    }

    /** @test */
    public function a_country_can_be_attached_to_a_specific_zone_if_not_already_attached_to_profile()
    {
        $shippingZone = create(ShippingZone::class)->first();
        $shippingZone->addCountry($this->country);

        $this->assertFalse($this->country->attachableTo(ShippingProfile::first()));
        $this->assertTrue($this->country->attachableTo(create(ShippingProfile::class)->first()));
    }
}
