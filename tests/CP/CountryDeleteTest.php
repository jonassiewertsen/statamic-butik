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

        $this->assertEquals(1, Country::count());

        $this->delete(route('statamic.cp.butik.countries.destroy', Country::first()))
            ->assertOk();

        $this->assertEquals(0, Country::count());
    }
}
