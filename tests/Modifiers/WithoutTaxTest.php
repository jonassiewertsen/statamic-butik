<?php

namespace Tests\Modifiers;

use Facades\Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Modifiers\WithoutTax;
use Tests\TestCase;

class WithoutTaxTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->modifier = new WithoutTax();
    }

    /** @test */
    public function the_tax_will_get_substracted_from_the_price()
    {
        $slug = $this->makeProduct()->slug;
        $product = Product::find($slug);

        $this->assertEquals(
            Price::of($product->price)->substract($product->tax_amount)->get(),
            $this->modifier->index($product->price, null, (array) $product)
        );
    }
}
