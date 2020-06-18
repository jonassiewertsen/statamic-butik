<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CountryCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function countries_can_be_created()
    {
        $country = raw(Country::class);
        $this->post(route('statamic.cp.butik.countries.store'), $country)->assertSessionHasNoErrors();
        $this->assertEquals(1, Country::count());
    }

    /** @test */
    public function name_is_required()
    {
        $shipping = raw(Country::class, ['name' => null]);
        $this->post(route('statamic.cp.butik.countries.store'), $shipping)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function slug_is_required()
    {
        $shipping = raw(Country::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.countries.store'), $shipping)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First country
        $country = raw(Country::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.countries.store'), $country)
            ->assertSessionHasNoErrors();

        // Another country with the same slug
        $country = raw(Country::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.countries.store'), $country)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function price_is_required()
    {
        $country = raw(Country::class, ['iso' => null]);
        $this->post(route('statamic.cp.butik.countries.store'), $country)
            ->assertSessionHasErrors('iso');
    }

}
