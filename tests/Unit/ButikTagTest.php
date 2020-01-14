<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Tags\Butik;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ButikTagTest extends TestCase
{
    public $butik;

    public function setUp(): void {
        parent::setUp();

        $this->butik = new Butik();
    }

    /** @test */
    public function the_butik_tag_has_been_registered()
    {
        $this->assertTrue(isset(app()['statamic.tags']['butik']));
    }

    /** @test */
    public function the_products_value_is_returning_the_product_collection()
    {
        $product = create(Product::class)->first();
        $this->assertStringContainsString($product->title, $this->butik->products());
//        $this->assertStringContainsString($product->images[0], $this->butik->products()->toJson()); // Image not tested
        $this->assertStringContainsString($product->base_price, $this->butik->products());
        $this->assertStringContainsString(json_encode($product->showUrl()), $this->butik->products());
    }

    /** @test */
    public function it_can_return_the_currency_symbol()
    {
        create(Product::class, [], 10);

        $this->assertEquals(
            $this->butik->currencySymbol(),
            config('statamic-butik.currency.symbol')
        );
    }
}
