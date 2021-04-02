<?php

namespace Tests\Fieldsets;

use Jonassiewertsen\Butik\Contracts\TaxRepository;
use Jonassiewertsen\Butik\Fieldtypes\Tax as TaxFieldset;
use Statamic\Contracts\Entries\Entry;
use Statamic\Facades\Entry as EntryFacade;
use Statamic\Fields\Field;
use Tests\TestCase;

class TaxFieldsetTest extends TestCase
{
    public Field $field;
    public TaxRepository $tax;
    public TaxFieldset $taxFieldset;
    public Entry $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->tax = $this->makeTax();
        $this->product = EntryFacade::find($this->makeProduct()->id);
        $this->field = (new Field('tax', []))->setParent($this->product);

        $this->taxFieldset = (new TaxFieldset())->setField($this->field);
    }

    /** @test */
    public function it_has_a_tax_rate()
    {
        $this->assertEquals(19, $this->taxFieldset->augment('default')['rate']);
    }

    /** @test */
    public function it_has_a_tax_amount()
    {
        $this->assertEquals('3,19', $this->taxFieldset->augment('default')['amount']);
    }

    /** @test */
    public function it_has_a_title()
    {
        $this->assertEquals('Test Tax', $this->taxFieldset->augment('default')['title']);
    }

    /** @test */
    public function return_an_empty_a()
    {
        $this->assertEquals('Test Tax', $this->taxFieldset->augment('default')['title']);
    }
}
