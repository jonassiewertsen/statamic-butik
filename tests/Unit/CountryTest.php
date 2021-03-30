<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Facades\Country;
use Tests\TestCase;

class CountryTest extends TestCase
{
    /** @test */
    public function a_default_name_will_be_set_from_the_session()
    {
        $this->assertEquals('Germany', Country::name());
    }

    /** @test */
    public function a_name_can_be_fetched_via_iso_code()
    {
        $this->assertEquals('Denmark', Country::name('DK'));
    }

    /** @test */
    public function iso_codes_can_inserted_case_insensetive()
    {
        $this->assertEquals('Denmark', Country::name('dK'));
    }

    /** @test */
    public function a_non_existing_name_will_return_null()
    {
        $this->assertNull(Country::name('XX'));
    }

    /** @test */
    public function an_iso_code_can_be_returned()
    {
        $this->assertEquals('DE', Country::iso());
    }

    /** @test */
    public function a_new_country_can_be_set()
    {
        Country::set('DK');

        $this->assertEquals('Denmark', Country::name());
        $this->assertEquals('DK', Country::iso());
    }

    /** @test */
    public function the_default_country_from_the_config_can_be_fetched()
    {
        Country::set('DK');

        $this->assertEquals('Germany', Country::defaultName());
        $this->assertEquals('DE', Country::defaultIso());
    }

    /** @test */
    public function It_can_be_checked_if_a_country_exists()
    {
        $this->assertTrue(Country::exists('DK'));
        $this->assertFalse(Country::exists('XX'));
    }
}
