<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Facades\Price;
use Tests\TestCase;

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
        $cents = Price::of(2312)->cents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_be_initiated_from_a_string()
    {
        $cents = Price::of('23.12')->cents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_be_initiated_from_a_string_with_comma()
    {
        $cents = Price::of('23,12')->cents();

        $this->assertEquals(2312, $cents);
    }

    /** @test */
    public function it_can_be_initiated_with_null()
    {
        $cents = Price::of(null)->cents();

        $this->assertEquals(0, $cents);
    }

    /** @test */
    public function it_can_return_a_human_value()
    {
        $amount = Price::of(2000)->get();

        $this->assertEquals('20,00', $amount);
    }

    /** @test */
    public function it_can_return_a_human_value_with_differnt_delimiters()
    {
        config()->set('butik.currency_delimiter', '@');

        $amount = Price::of(2000)->get();

        $this->assertEquals('20@00', $amount);
    }

    /** @test */
    public function a_delimiter_can_be_set()
    {
        $amount = Price::of(2245)->delimiter('!')->get();

        $this->assertEquals('22!45', $amount);
    }

    /** @test */
    public function a_thousands_separator_can_be_set()
    {
        $amount = Price::of(2334455)->thousands('!')->get();

        $this->assertEquals('23!344,55', $amount);
    }

    /** @test */
    public function a_price_can_be_added()
    {
        $amount = Price::of(1234)->add(4321)->cents();

        $this->assertEquals(5555, $amount);
    }

    /** @test */
    public function a_price_can_be_substraccted()
    {
        $amount = Price::of(2345)->subtract(123)->cents();

        $this->assertEquals(2222, $amount);
    }

    /** @test */
    public function a_price_can_be_multiplied()
    {
        $amount = Price::of(1111)->multiply(3)->cents();

        $this->assertEquals(3333, $amount);
    }

    /** @test */
    public function a_price_can_be_divided()
    {
        $amount = Price::of(550)->divide(55)->cents();

        $this->assertEquals(10, $amount);
    }

    /** @test */
    public function a_price_calculate_with_priceobjects_itself()
    {
        $amount1 = Price::of(300);
        $amount2 = Price::of(200);

        $this->assertEquals(500, Price::of($amount1)->add($amount2)->cents());
    }
}
