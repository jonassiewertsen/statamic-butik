<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryDeleteTest extends TestCase
{
    /** @test */
    public function A_product_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $country = create(Country::class);
        $this->assertEquals(1, $country->count());

        $this->delete(route('statamic.cp.butik.countries.destroy', $country->first()))
            ->assertOk();

        $this->assertEquals(0, Country::count());
    }
}
