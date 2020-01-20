<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_is_available_as_default(){
        $product = create(Product::class)->first();
        $this->assertTrue(Product::first()->available);
    }

    /** @test */
    public function it_has_a_shipping_amount(){
        $product = create(Product::class)->first();
        $this->assertEquals($product->shipping->price, $product->shipping_amount);
    }

    /** @test */
    public function it_has_a_tax_percentage(){
        $product = create(Product::class)->first();
        $this->assertEquals($product->tax->percentage, $product->tax_percentage);
    }

    /** @test */
    public function it_has_tax_amount(){
        $product = create(Product::class)->first();

        $divisor            = $product->tax->percentage + 100;
        $base_price         = $product->getOriginal('base_price');
        $shipping_amount    = $product->shipping->getOriginal('price');
        $total_amount       = $base_price + $shipping_amount;

        $totalPriceWithoutTax = $total_amount / $divisor * 100;
        $tax = $product->makeAmountHuman($total_amount - $totalPriceWithoutTax);
        $this->assertEquals($tax, $product->tax_amount);
    }

    /** @test */
    public function it_has_a_total_price(){
        $product = create(Product::class)->first();
        $amount = $product->getOriginal('base_price') + $product->shipping->getOriginal('price');

        $this->assertEquals(
            $product->makeAmountHuman($amount),
            $product->total_price
        );
    }
    
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
        $this->assertEquals('€ 2,00', $product->first()->basePriceWithCurrencySymbol);
    }

    /** @test */
    public function it_has_a_edit_url()
    {
        $product = create(Product::class)->first();

        $this->assertEquals(
            $product->editUrl,
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
            $product->showUrl
        );
    }

    /** @test */
    public function it_has_a_express_checkout_delivery_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/delivery/{$product->slug}",
            $product->expressDeliveryUrl
        );
    }

    /** @test */
    public function it_has_a_express_checkout_payment_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/payment/{$product->slug}",
            $product->expressPaymentUrl
        );
    }

    /** @test */
    public function it_has_a_express_checkout_receipt_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('statamic-butik.uri.prefix');
        $this->assertEquals(
            "/shop/express-checkout/receipt/{$product->slug}",
            $product->expressReceiptUrl
        );
    }

    /** @test */
    public function it_has_a_tax(){
        $product = create(Product::class)->first();

        $this->assertInstanceOf(Tax::class, $product->tax);
    }

    /** @test */
    public function it_has_a_shipping(){
        $this->withoutExceptionHandling();
        $product = create(Product::class)->first();

        $this->assertInstanceOf(Shipping::class, $product->shipping);
    }
}
