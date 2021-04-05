<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Jonassiewertsen\Butik\Product\Price;
use Tests\TestCase;

class PriceAsNetTest extends TestCase
{
    public ProductRepository $product;
    public TaxCalculator $tax;

    public function setUp(): void
    {
        parent::setUp();

        config()->set('butik.price', 'net');

        $this->makeTax();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function a_net_price_will_get_calculated()
    {
        $price = new Price($this->product);

        $this->assertEquals('20,00', $price->net()->get());
    }

    /** @test */
    public function a_gross_price_will_get_calculated()
    {
        $price = new Price($this->product);

        $this->assertEquals('23,80', $price->gross()->get());
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
}
