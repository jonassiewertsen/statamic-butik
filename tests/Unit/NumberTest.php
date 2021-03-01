<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Facades\Number;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class NumberTest extends TestCase
{
    public string $delimiter;

    /** @test */
    public function it_can_be_initiated_as_an_integer_and_get_returned_as_integer()
    {
        $number = Number::of(23)->int();

        $this->assertEquals(23, $number);
    }

    /** @test */
    public function it_can_be_initiated_as_an_integer_and_get_returned_as_decimal()
    {
        $number = Number::of(23)->decimal();

        $this->assertEquals(23.0, $number);
    }

    /** @test */
    public function it_can_be_initiated_a_float_and_get_returned_as_integer()
    {
        $number = Number::of(23.00)->int();

        $this->assertEquals(23, $number);
    }

    /** @test */
    public function it_can_be_initiated_a_string_with_dot_and_get_retunred_as_integer()
    {
        $number = Number::of('23.12')->decimal();

        $this->assertEquals(23.12, $number);
    }

    /** @test */
    public function it_can_be_initiated_as_a_string_and_get_retunred_as_integer()
    {
        $number = Number::of('23,12')->decimal();

        $this->assertEquals(23.12, $number);
    }

    /** @test */
    public function a_number_can_be_added()
    {
        $number = Number::of('23,12')->add(10)->decimal();

        $this->assertEquals(33.12, $number);
    }

    /** @test */
    public function a_number_can_be_substracted()
    {
        $number = Number::of('23,12')->subtract(10)->decimal();

        $this->assertEquals(13.12, $number);
    }
}
