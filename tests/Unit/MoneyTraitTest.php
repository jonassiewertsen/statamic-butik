<?php

namespace Tests\Unit;

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
    public function does_not_care_about_dot_or_commas()
    {
        $original = '5.32';
        $converted = $this->makeAmountSaveable($original);

        $this->assertEquals(532, $converted);
    }

    /** @test */
    public function Amounts_will_be_made_human_again()
    {
        $original = '543';
        $converted = $this->makeAmountHuman($original);

        $this->assertEquals('5,43', $converted);
    }
}
