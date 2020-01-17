<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
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

    /** @test */
    public function it_has_a_edit_url()
    {
        $product = create(Product::class)->first();

        $this->assertEquals(
            $product->editUrl(),
            '/'.config('statamic.cp.route')."/butik/products/{$product->slug}/edit"
            );
    }

    /** @test */
    public function it_has_a_show_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/{$product->slug}",
            $product->showUrl()
        );
    }

    /** @test */
    public function it_has_a_express_checkout_delivery_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/delivery/{$product->slug}",
            $product->expressDeliveryUrl()
        );
    }

    /** @test */
    public function it_has_a_express_checkout_payment_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/payment/{$product->slug}",
            $product->expressPaymentUrl()
        );
    }

    /** @test */
    public function it_has_a_express_checkout_receipt_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/receipt/{$product->slug}",
            $product->expressReceiptUrl()
        );
    }

    /** @test */
    public function it_has_taxes(){
        $this->withoutExceptionHandling();
        $product = create(Product::class)->first();

        $this->assertInstanceOf(Tax::class, $product->taxes);
    }
}
