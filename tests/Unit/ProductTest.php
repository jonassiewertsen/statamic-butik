<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function the_currency_will_be_converted_correctly()
    {
        $product = create(Product::class, ['base_price' => 2 ]);
        $this->assertEquals('2,00', $product->first()->base_price);
    }

    /** @test */
    public function the_currency_will_be_saved_without_decimals()
    {
        create(Product::class, ['base_price' => '2,00' ]);
        $this->assertEquals('200', Product::first()->getOriginal('base_price'));
    }

    /** @test */
    public function the_currency_can_output_the_currency_symbol()
    {
        $product = create(Product::class, ['base_price' => 2 ]);
        $this->assertEquals('2,00 €', $product->first()->basePriceWithCurrencySymbol);
    }
}
