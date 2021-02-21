<?php

namespace Jonassiewertsen\StatamicButik\Tests\Fieldsets;

use Statamic\Fields\Field;
use Jonassiewertsen\StatamicButik\Fieldtypes\Money;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class MoneyFieldsetTest extends TestCase
{
    // TODO: Calculate prices depending on taxes

    /** @test */
    public function it_has_a_total_value_as_gross_price()
    {
        config()->set('butik.price', 'gross');

        $value = (new Money())
            ->setField(new Field('test', []))
            ->augment('10.00');

        $this->assertEquals($value['total'], '10.00');
    }

    /** @test */
    public function it_has_a_total_value_as_net_price()
    {
        config()->set('butik.price', 'net');

        $value = (new Money())
            ->setField(new Field('test', []))
            ->augment('10.00');

        $this->assertEquals($value['net'], '10.00');
    }

    /** @test */
    public function it_has_a_gross_price()
    {
        $value = (new Money())
            ->setField(new Field('test', []))
            ->augment('10.00');

        $this->assertEquals($value['gross'], '10.00');
    }

    /** @test */
    public function it_has_a_net_price()
    {
        $value = (new Money())
            ->setField(new Field('test', []))
            ->augment('10.00');

        $this->assertEquals($value['net'], '10.00');
    }
}
