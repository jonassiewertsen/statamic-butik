<?php

namespace Jonassiewertsen\StatamicButik\Tests\Fieldsets;

use Statamic\Fields\Field;
use Jonassiewertsen\StatamicButik\Fieldtypes\Money;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class MoneyFieldsetTest extends TestCase
{
    // TODO: Calculate prices depending on taxes

    // TODO: Rename the money fieldset to a price fieldset

    /** @test */
    public function it_has_a_total_value_as_gross_price()
    {
        config()->set('butik.price', 'gross');

        $price = $this->priceFieldset();

        $this->assertEquals($price['total'], '10.00');
    }

    /** @test */
    public function it_has_a_total_value_as_net_price()
    {
        config()->set('butik.price', 'net');

        $price = $this->priceFieldset();

        $this->assertEquals($price['net'], '10.00');
    }

    /** @test */
    public function it_has_a_gross_price()
    {
        $price = $this->priceFieldset();

        $this->assertEquals($price['gross'], '10.00');
    }

    /** @test */
    public function it_has_a_net_price()
    {
        $price = $this->priceFieldset();

        $this->assertEquals($price['net'], '10.00');
    }

    private function priceFieldset($value = '10.00'): array
    {
        return (new Money())
            ->setField(new Field('test', []))
            ->augment($value);
    }
}
