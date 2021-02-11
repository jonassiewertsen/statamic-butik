<?php

namespace Jonassiewertsen\StatamicButik\Tests\Fieldsets;

use Statamic\Fields\Field;
use Jonassiewertsen\StatamicButik\Fieldtypes\Money;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductFieldsetTest extends TestCase
{
    /** @test */
    public function test()
    {
        $value = (new Money())
            ->setField(new Field('test', []))
            ->augment('10.00');

        $this->assertEquals($value['total'], '10.00');
        // TODO: Add gross
        // TODO: Add net
    }
}
