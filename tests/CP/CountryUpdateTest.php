<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryUpdateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function the_title_can_be_updated()
    {
        $country       = create(Country::class)->first();
        $country->name = 'Updated Name';
        $this->updateCountry($country)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_countries', ['name' => 'Updated Name']);
    }

    /** @test */
    public function the_iso_can_be_updated()
    {
        $country      = create(Country::class)->first();
        $country->iso = 'NEW';
        $this->updateCountry($country);
        $this->assertDatabaseHas('butik_countries', ['iso' => 'NEW']);
    }

    private function updateCountry($country)
    {
        return $this->patch(route('statamic.cp.butik.countries.update', $country), $country->toArray());
    }
}
