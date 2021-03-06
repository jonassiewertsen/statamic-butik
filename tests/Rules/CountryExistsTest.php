<?php

namespace Tests\Rules;

use Jonassiewertsen\Butik\Rules\CountryExists;
use Jonassiewertsen\Butik\Tests\TestCase;

class CountryExistsTest extends TestCase
{
    /** @test */
    public function will_return_true_if_the_country_exists()
    {
        $rule = new CountryExists();

        $this->assertTrue($rule->passes('attribute', ['DE']));
    }

    /** @test */
    public function it_can_validate_multiple_country_codes()
    {
        $rule = new CountryExists();

        $this->assertTrue($rule->passes('attribute', ['DE', 'DK', 'GB']));
    }

    /** @test */
    public function it_will_detect_a_false_code_inside_existing_codes()
    {
        $rule = new CountryExists();

        $this->assertFalse($rule->passes('attribute', ['DE', 'not-existing', 'DK']));
    }
}
