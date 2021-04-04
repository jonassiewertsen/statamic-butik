<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Product\Calculator\TaxCalculator;
use Jonassiewertsen\Butik\Repositories\TaxRepository;
use Tests\TestCase;

class TaxCaluclatorGrossTest extends TestCase
{
    public ProductRepository $product;
    public TaxRepository $tax;
    public TaxRepository $danishTax;

    public function setUp(): void
    {
        parent::setUp();
        $this->tax = $this->makeTax();
        $this->product = $this->makeProduct(['price' => '20']);
        $this->danishTax = $this->makeTax(['countries' => ['DK'], 'rate' => 25]);
    }

    /** @test */
    public function it_has_a_single_tax_amount()
    {
        $tax = new TaxCalculator($this->product);

        $this->assertEquals('3,19', $tax->single()->get());
    }

    /** @test */
    public function it_has_a_single_tax_amount_for_different_countries()
    {
        $tax = new TaxCalculator($this->product, 1, 'DK');

        $this->assertEquals('4,00', $tax->single()->get());
    }

    /** @test */
    public function it_has_a_total_tax_amount()
    {
        $tax = new TaxCalculator($this->product, 2);

        $this->assertEquals('6,38', $tax->total()->get());
    }

    /** @test */
    public function it_has_a_total_tax_amount_for_different_countries()
    {
        $tax = new TaxCalculator($this->product, 2, 'DK');

        $this->assertEquals('8,00', $tax->total()->get());
    }

    /** @test */
    public function it_has_a_tax_rate()
    {
        $tax = new TaxCalculator($this->product);

        $this->assertEquals($tax->rate(), $this->tax->rate);
    }
}
