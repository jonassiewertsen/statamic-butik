<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_is_available_as_default()
    {
        $product = create(Product::class)->first();
        $this->assertTrue(Product::first()->available);
    }

    /** @test */
    public function it_has_a_tax_percentage()
    {
        $product = create(Product::class)->first();
        $this->assertEquals($product->tax->percentage, $product->tax_percentage);
    }

    /** @test */
    public function it_has_tax_amount()
    {
        $product = create(Product::class)->first();

        $divisor = $product->tax->percentage + 100;
        $price   = $product->getRawOriginal('price');

        $totalPriceWithoutTax = $price / $divisor * 100;
        $tax                  = $product->makeAmountHuman($price - $totalPriceWithoutTax);
        $this->assertEquals($tax, $product->tax_amount);
    }

    /** @test */
    public function the_currency_will_be_converted_correctly()
    {
        $product = create(Product::class, ['price' => 2]);
        $this->assertEquals('2,00', $product->first()->price);
    }

    /** @test */
    public function the_currency_will_be_saved_without_decimals()
    {
        create(Product::class, ['price' => '2,00']);
        $this->assertEquals('200', Product::first()->getRawOriginal('price'));
    }

    /** @test */
    public function it_has_a_edit_url()
    {
        $product = create(Product::class)->first();

        $this->assertEquals(
            $product->editUrl,
            '/' . config('statamic.cp.route') . "/butik/products/{$product->slug}/edit"
        );
    }

    /** @test */
    public function it_has_a_show_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('butik.route_shop-prefix');
        $this->assertEquals(
            "/shop/{$product->slug}",
            $product->showUrl
        );
    }

    /** @test */
    public function it_has_a_express_checkout_delivery_url()
    {
        $product = create(Product::class)->first();

        $uri_prefix = config('butik.route_shop-prefix');
        $this->assertEquals(
            "/shop/express-checkout/delivery/{$product->slug}",
            $product->expressDeliveryUrl
        );
    }

    /** @test */
    public function it_has_a_tax()
    {
        $product = create(Product::class)->first();

        $this->assertInstanceOf(Tax::class, $product->tax);
    }

    /** @test */
    public function it_is_sold_out_if_the_stock_is_null()
    {
        $product = create(Product::class, ['stock' => 0, 'stock_unlimited' => false])->first();

        $this->assertTrue($product->soldOut);
    }

    /** @test */
    public function it_is_not_sold_out_if_the_product_is_unlimited()
    {
        $product = create(Product::class, ['stock' => 0, 'stock_unlimited' => true])->first();

        $this->assertFalse($product->soldOut);
    }

    /** @test */
    public function it_has_a_currency()
    {
        $product = create(Product::class)->first();

        $this->assertEquals($product->currency, '€');
    }

    /** @test */
    public function it_belongs_to_a_shipping_profile()
    {
        $product = create(Product::class)->first();

        $this->assertInstanceOf(ShippingProfile::class, $product->shippingProfile);
    }
}
