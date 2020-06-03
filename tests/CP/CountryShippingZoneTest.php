<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryShippingZoneTest extends TestCase
{
    public $shippingZone;

    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();

        create(Country::class);
        $this->shippingZone = create(ShippingZone::class)->first();
        $this->shippingZone->addCountry(Country::first()->slug);
    }

    /** @test */
    public function the_reponse_has_the_correct_json_structure()
    {
        $country = Country::first();

        $this->get(cp_route('butik.country-shipping-zone.index', $this->shippingZone))
            ->assertJsonFragment([
                'name'            => $country->name,
                'slug'            => $country->slug,
                'iso'             => $country->iso,
                'current_zone'    => true,
                'can_be_attached' => false,
            ]);
    }

    /** @test */
    public function a_country_can_be_in_a_specific_zone()
    {
        $country = Country::first();
        $this->shippingZone->removeCountry($country);

        $this->get(cp_route('butik.country-shipping-zone.index', $this->shippingZone))
            ->assertJsonFragment([
                'name'         => $country->name,
                'current_zone' => false,
            ]);
    }

    /** @test */
    public function a_country_may_be_attachable()
    {
        $country = Country::first();
        $this->shippingZone->removeCountry($country);

        $this->get(cp_route('butik.country-shipping-zone.index', $this->shippingZone))
            ->assertJsonFragment([
                'name'            => $country->name,
                'can_be_attached' => true,
            ]);
    }
}
