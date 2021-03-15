<?php

namespace Tests\Fieldsets;

use Jonassiewertsen\Butik\Fieldtypes\Tax as TaxFieldset;
use Jonassiewertsen\Butik\Http\Models\Tax;
use Tests\TestCase;
use Statamic\Fields\Field;

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

        // TODO: Replace with Price facade as soon as it's done
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
