<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

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
}
