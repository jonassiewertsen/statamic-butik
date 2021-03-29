<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Product\Price;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;
use Tests\TestCase;

class PriceTest extends TestCase
{
    public ProductRepository $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function it_has_a_single_price()
    {
        $price = new Price($this->product);

        $this->assertEquals($price->single(), PriceFacade::of($this->productPrice()));
    }

    /** @test */
    public function it_has_a_total_price()
    {
        $price = new Price($this->product, 2);

        $this->assertEquals($price->total(), PriceFacade::of($this->productPrice())->multiply(2));
    }

    private function productPrice()
    {
        return $this->product->entry->get('price');
    }
}
