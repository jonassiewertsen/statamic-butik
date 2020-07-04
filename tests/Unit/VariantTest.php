<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class VariantTest extends TestCase
{
       /** @test */
    public function the_currency_will_be_converted_correctly()
    {
        $product = create(Variant::class, ['price' => 2]);
        $this->assertEquals('2,00', $product->first()->price);
    }

    /** @test */
    public function the_currency_will_be_saved_without_decimals()
    {
        create(Variant::class, ['price' => '2,00']);
        $this->assertEquals('200', Variant::first()->getRawOriginal('price'));
    }
}
