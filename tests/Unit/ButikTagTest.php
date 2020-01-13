<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Tags\Butik;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ButikTagTest extends TestCase
{
    public $tag;

    public function setUp(): void {
        parent::setUp();

        $this->butik = new Butik();
    }

    /** @test */
    public function the_batiks_tag_has_been_registered()
    {
        $this->assertTrue(isset(app()['statamic.tags']['butik']));
    }

    /** @test */
    public function the_products_map_is_returning_the_product_collection()
    {
        create(Product::class, [], 10);

        $this->assertEquals(
            $this->butik->products(),
            Product::all()
        );
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
