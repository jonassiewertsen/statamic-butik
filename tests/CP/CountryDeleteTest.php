<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryDeleteTest extends TestCase
{
    /** @test */
    public function A_country_can_be_deleted()
    {
        $this->signInAdmin();

        $country = create(Country::class);
        $this->assertDatabaseHas('butik_countries', $country->toArray());

        $this->delete(route('statamic.cp.butik.countries.destroy', $country->first()))
            ->assertOk();

        $$this->assertDatabaseMissing('butik_countries', $country->toArray());
    }
}
