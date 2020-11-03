<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class MoneyTraitTest extends TestCase
{
    use MoneyTrait;

    public function setUp(): void {
        parent::setUp();
    }

    /** @test */
    public function it_will_make_an_amount_saveable()
    {
        $original = '5,00';
        $converted = $this->makeAmountSaveable($original);

        $this->assertEquals(500, $converted);
    }

    /** @test */
    public function it_will_make_an_odd_amount_saveable()
    {
        $original = '5,32';
        $converted = $this->makeAmountSaveable($original);

        $this->assertEquals(532, $converted);
    }

    /** @test */
    public function a_price_can_be_forced_to_return_it_with_a_dot()
    {
        $original = '5,32';
        $converted = $this->humanPriceWithDot($original);

        $this->assertEquals(5.32, $converted);
    }

    /** @test */
    public function a_price_can_be_forced_to_return_as_defined_in_the_config()
    {
        $original = '5.32';
        $converted = $this->humanPrice($original);

        $this->assertEquals('5,32', $converted);
    }

    /** @test */
    public function does_not_care_about_dot_or_commas()
    {
        $original = '5.32';
        $converted = $this->makeAmountSaveable($original);

        $this->assertEquals(532, $converted);
    }

    /** @test */
    public function amounts_will_be_made_human_again()
    {
        $original = '543';
        $converted = $this->makeAmountHuman($original);

        $this->assertEquals('5,43', $converted);
    }

    /** @test */
    public function will_return_a_human_price_with_dot()
    {
        $original = '5,43';
        $converted = $this->humanPriceWithDot($original);

        $this->assertEquals('5.43', $converted);
    }

    /** @test */
    public function will_return_a_human_price_with_dot_always_with_2_decimals_after_the_comma()
    {
        $original = '0';
        $converted = $this->humanPriceWithDot($original);

        $this->assertEquals('0.00', $converted);
    }
}
