<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Facades\Price;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class PriceTest extends TestCase
{
    public string $delimiter;

    public function setUp(): void
    {
        parent::setUp();

        $this->delimiter = config('butik.currency_delimiter');
    }

    /** @test */
    public function it_can_be_initiated_from_cents_and_return_cents()
    {
        $cents = Price::of(2312)->getCents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_be_initiated_from_a_string()
    {
        $cents = Price::of('23.12')->getCents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_be_initiated_from_a_string_with_comma()
    {
        $cents = Price::of('23,12')->getCents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_return_a_human_value()
    {
        $amount = Price::of(2000)->getAmount();

        $this->assertEquals('20,00', $amount);
    }

    /** @test */
    public function it_can_return_a_human_value_with_differnt_delimiters()
    {
        config()->set('butik.currency_delimiter', '@');

        $amount = Price::of(2000)->getAmount();

        $this->assertEquals('20@00', $amount);
    }
}
