<?php

namespace Jonassiewertsen\StatamicButik\Tests\Modifiers;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Modifiers\WithoutTax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class WithoutTaxTest extends TestCase
{
    use MoneyTrait;

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

        $price = $this->makeAmountSaveable($product->price);
        $tax = $this->makeAmountSaveable($product->tax_amount);

        $this->assertEquals(
            $this->makeAmountHuman($price - $tax),
            $this->modifier->index($product->price, null, (array) $product)
        );
    }
}
