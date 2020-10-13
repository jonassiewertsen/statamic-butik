<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Statamic\Facades\Site;

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
    public function will_return_the_actual_locale()
    {
        $this->assertEquals(
            locale(),
            Site::current()->url(),
        );
    }
}
