<?php

namespace Jonassiewertsen\Butik\Tests\Fieldsets;

use Jonassiewertsen\Butik\Fieldtypes\Money;
use Jonassiewertsen\Butik\Tests\TestCase;
use Statamic\Entries\Entry;
use Statamic\Fields\Field;

class MoneyFieldsetTest extends TestCase
{
    public Entry $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
    }

    /** @test */
    public function the_total_value_is_the_default_and_raw_value_from_the_product_entry()
    {
        $price = $this->product->augmentedValue('price');

        $this->assertEquals($price->raw(), $price->value()['total']);
    }

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
        $price = $this->product->augmentedValue('price');
        $tax = $this->product->augmentedValue('tax_id');

        // TODO: Calculate prices depending on taxes

        $this->assertEquals($price['net'], '1.00');
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
