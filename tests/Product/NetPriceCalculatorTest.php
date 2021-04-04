<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Product\Calculator\NetPriceCalculator;
use Jonassiewertsen\Butik\Product\Calculator\TaxCalculator;
use Tests\TestCase;
use Tests\Utilities\Trais\SetPriceType;

class NetPriceCalculatorTest extends TestCase
{
    use SetPriceType;

    public NetPriceCalculator $priceCalculator;
    public TaxCalculator $taxCalculator;

    public function setUp(): void
    {
        parent::setUp();

        $this->tax = $this->makeTax();
        $this->product = $this->makeProduct(['price' => '20']);
        $this->taxCalculator = new TaxCalculator($this->product);
    }

    /** @test */
    public function it_has_a_base_price()
    {
        $price = new NetPriceCalculator($this->product);

        $this->assertEquals('20,00', $price->base()->get());
    }

    /** @test */
    public function it_has_a_single_net_price()
    {
        $price = new NetPriceCalculator($this->product);

        $this->assertEquals('16,81', $price->single()->get());

        $this->setNetPriceAsDefault();

        $this->assertEquals('20,00', $price->single()->get());
    }

    /** @test */
    public function it_has_a_total_gross_price()
    {
        $price = new NetPriceCalculator($this->product, 2);

        $this->assertEquals('33,62', $price->total()->get());

        $this->setNetPriceAsDefault();

        $this->assertEquals('40,00', $price->total()->get());
    }

    /** @test */
    public function the_price_can_be_returned_as_a_string()
    {
        $price = new NetPriceCalculator($this->product, 3);

        $this->assertEquals('50,43', $price->get());
    }
}
