<?php

namespace Jonassiewertsen\StatamicButik\Tests\Fieldsets;

use Jonassiewertsen\StatamicButik\Fieldtypes\Tax as TaxFieldset;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Fields\Field;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxFieldsetTest extends TestCase
{
    /** @test */
    public function it_has_a_percentage_value()
    {
        $taxModel = create(Tax::class)->first();
        $tax = $this->taxFieldset($taxModel->slug);

        $this->assertEquals($tax['percentage'], $taxModel->percentage);
    }

    /** @test */
    public function it_has_a_calculated_tax_amount()
    {
        $product = $this->makeProduct();
        $tax = $product->augmentedValue('tax_id')->value();

        $calculatedTaxAmount = (float) $product->price * ($tax['percentage'] / 100);
        $calculatedTaxAmount = number_format((float) $calculatedTaxAmount, '2', ',', '.');

        $this->assertEquals($tax['amount'], $calculatedTaxAmount);
    }

    /** @test */
    public function it_has_a_name()
    {
        $taxModel = create(Tax::class)->first();
        $tax = $this->taxFieldset($taxModel->slug);

        $this->assertEquals($tax['name'], $taxModel->title);
    }

    /** @test */
    public function it_has_a_slug()
    {
        $taxModel = create(Tax::class)->first();
        $tax = $this->taxFieldset($taxModel->slug);

        $this->assertEquals($tax['slug'], $taxModel->slug);
    }

    private function taxFieldset($value = 'default'): array
    {
        return (new TaxFieldset())
            ->setField(new Field('test', []))
            ->augment($value);
    }
}
