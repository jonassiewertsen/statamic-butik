<?php

namespace Jonassiewertsen\Butik\Tests\Unit;

use Jonassiewertsen\Butik\Tests\TestCase;
use Statamic\Facades\Site;
use Statamic\Support\Str;

class GlobalHelperTest extends TestCase
{
    /** @test */
    public function the_is_a_currency_helper()
    {
        $this->assertEquals(
            currency(),
            config('butik.currency_symbol')
        );
    }

    /** @test */
    public function will_return_the_actual_locale_in_a_multisite()
    {
        $this->assertEquals(
            locale(),
            Str::of(Site::current()->locale())->explode('_')->first()
        );
    }

    /** @test */
    public function will_return_the_actual_url_on_the_default_page()
    {
        $this->assertEquals('/', locale_url());
    }

    /** @test */
    public function will_return_the_actual_url_on_a_multisite()
    {
        $this->multisite();

        $this->assertEquals('/de', locale_url());
    }
}
