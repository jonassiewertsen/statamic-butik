<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Tags\Route;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class RouteTagTest extends TestCase
{
    // TODO: To keep or not ?

    public $tag;
    public $product;

    public function setUp(): void {
        parent::setUp();

        $this->tag = new Route();
        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function the_butik_tag_has_been_registered()
    {
        $this->assertTrue(isset(app()['statamic.tags']['route']));
    }

    /** @test */
    public function express_delivery_routes_will_be_defined()
    {
        $this->tag->setParameters(['slug' => $this->product->slug]);

        $this->assertEquals(
            route('butik.checkout.express.delivery', $this->product),
            $this->tag->widlcard('checkout.express.delivery')
        );
    }

    /** @test */
    public function express_payment_routes_will_be_defined()
    {
        $this->tag->setParameters(['slug' => $this->product->slug]);

        $this->assertEquals(
            route('butik.checkout.express.payment', $this->product),
            $this->tag->widlcard('checkout.express.payment')
        );
    }
//
//    /** @test */
//    public function it_can_return_the_currency_symbol()
//    {
//        create(Product::class, [], 10);
//
//        $this->assertEquals(
//            $this->butik->currencySymbol(),
//            config('statamic-butik.currency.symbol')
//        );
//    }
//
//    /** @test */
//    public function it_can_return_the_shop_link_link()
//    {
//        $this->assertEquals(
//            $this->butik->overview(),
//            config('statamic-butik.uri.shop')
//        );
//    }
}
