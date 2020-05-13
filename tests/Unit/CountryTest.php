<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryTest extends TestCase
{
    /** @test */
    public function it_has_a_edit_url()
    {
        $country = create(Country::class)->first();

        $this->assertEquals(
            $country->editUrl,
            '/'.config('statamic.cp.route')."/butik/settings/countries/{$country->slug}/edit"
            );
    }
}
