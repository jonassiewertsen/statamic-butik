<?php

namespace Tests\Product;

use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Price as PriceFacade;
use Jonassiewertsen\Butik\Product\Tax;
use Tests\TestCase;

class TaxTest extends TestCase
{
    public ProductRepository $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = $this->makeProduct();
    }

    /** @test */
    public function it_has_a_single_tax_rate()
    {
        $tax = new Tax($this->product);

        $this->assertEquals($tax->single(), PriceFacade::of($this->productTaxes()['amount']));
    }

    /** @test */
    public function it_has_a_total_price()
    {
        $tax = new Tax($this->product, 2);

        $this->assertEquals($tax->total(), PriceFacade::of($this->productTaxes()['amount'])->multiply(2));
    }

    /** @test */
    public function it_has_a_rate()
    {
        $tax = new Tax($this->product, 2);

        $this->assertEquals($tax->rate(), $this->productTaxes()['rate']);
    }

    private function productTaxes(): array
    {
        return $this->product->entry->augmentedValue('tax_id')->value();
    }
}
