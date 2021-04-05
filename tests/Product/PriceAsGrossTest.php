<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Product\Calculator\GrossPriceCalculator;
use Jonassiewertsen\Butik\Product\Calculator\NetPriceCalculator;
use Jonassiewertsen\Butik\Product\Price;
use Tests\TestCase;

class PriceAsGrossTest extends TestCase
{
    public ProductRepository $product;
    public TaxCalculator $tax;

    public function setUp(): void
    {
        parent::setUp();

        $this->makeTax();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function the_net_price_will_return_the_correct_instance()
    {
        $price = new Price($this->product);

        $this->assertInstanceOf(NetPriceCalculator::class, $price->net());
    }

    /** @test */
    public function the_gross_price_will_return_the_correct_instance()
    {
        $price = new Price($this->product);

        $this->assertInstanceOf(GrossPriceCalculator::class, $price->gross());
    }

    /** @test */
    public function a_net_price_will_get_calculated()
    {
        $price = new Price($this->product);

        $this->assertEquals('16,81', $price->net()->get());
    }

    /** @test */
    public function a_gross_price_will_get_calculated()
    {
        $price = new Price($this->product);

        $this->assertEquals('20,00', $price->gross()->get());
    }

    /** @test */
    public function it_can_return_the_total_price_as_price_repository()
    {
        $price = new Price($this->product);

        $this->assertEquals('20,00', $price->total()->get());
    }

    /** @test */
    public function it_can_return_the_total_price_as_string()
    {
        $price = new Price($this->product);

        $this->assertEquals('20,00', $price->get());
    }

    /** @test */
    public function it_has_a_base_price()
    {
        $price = new Price($this->product);

        $this->assertEquals('20,00', $price->base()->get());
    }
}
