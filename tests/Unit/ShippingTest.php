<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTest extends TestCase
{
    /** @test */
    public function the_currency_will_be_converted_correctly()
    {
        $shipping = create(Shipping::class, ['price' => 2 ]);
        $this->assertEquals('2,00', $shipping->first()->price);
    }

    /** @test */
    public function the_currency_will_be_saved_without_decimals()
    {
        create(Shipping::class, ['price' => '2,00' ]);
        $this->assertEquals('200', Shipping::first()->getOriginal('price'));
    }

    /** @test */
    public function the_currency_can_output_the_currency_symbol()
    {
        $shipping = create(Shipping::class, ['price' => 2 ]);
        $this->assertEquals('€ 2,00', $shipping->first()->priceWithCurrencySymbol);
    }

    /** @test */
    public function shippings_have_a_edit_url()
    {
        $shipping = create(Shipping::class)->first();

        $this->assertStringContainsString(
            $shipping->editUrl(),
            cp_route('butik.shippings.edit', $shipping)
        );
    }

    /** @test */
    public function it_has_products(){
        $shipping = create(Shipping::class)->first();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shipping->products);
    }
}
