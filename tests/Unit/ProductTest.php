<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductTest extends TestCase
{
    public Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product       = new Product();
        $this->product->slug = 'test-product';
    }

    /** @test */
    public function it_has_a_tax()
    {
        $tax                   = create(Tax::class)->first();
        $this->product->tax_id = $tax->slug;

        $this->assertInstanceOf(Tax::class, $this->product->tax);
    }

    /** @test */
    public function it_has_tax_amount()
    {
        $tax                   = create(Tax::class)->first();
        $this->product->tax_id = $tax->slug;

        $divisor = $this->product->tax->percentage / 100 + 1;
        $price   = $this->product->price = '10.00';

        $priceWithoutTax = round($price / $divisor, 2);
        $expectedAmount = str_replace('.', ',', $price - $priceWithoutTax);

        $this->assertEquals($expectedAmount, $this->product->tax_amount);
    }

    /** @test */
    public function it_has_a_tax_percentage()
    {
        $tax                   = create(Tax::class)->first();
        $this->product->tax_id = $tax->slug;

        $this->assertEquals($tax->percentage, $this->product->tax_percentage);
    }

    /** @test */
    public function it_has_a_show_url()
    {
        $this->assertEquals(
            "/shop/{$this->product->slug}",
            $this->product->show_url
        );
    }

    /** @test */
    public function it_is_sold_out_if_the_stock_is_null()
    {
        $this->product->stock_unlimited = false;
        $this->product->stock           = 0;

        $this->assertTrue($this->product->sold_out);
    }

    /** @test */
    public function it_is_not_sold_out_if_the_product_is_unlimited()
    {
        $this->product->stock_unlimited = true;
        $this->product->stock           = 0;

        $this->assertFalse($this->product->sold_out);
    }

    /** @test */
    public function it_has_a_currency()
    {
        $this->assertEquals($this->product->currency, '€');
    }

    /** @test */
    public function it_belongs_to_a_shipping_profile()
    {
        $profile                              = create(ShippingProfile::class)->first();
        $this->product->shipping_profile_slug = $profile->slug;

        $this->assertInstanceOf(ShippingProfile::class, $this->product->shipping_profile);
    }

    /** @test */
    public function it_has_many_categories()
    {
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->product->categories);
    }

    /** @test */
    public function it_has_many_variants()
    {
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->product->variants);
    }

    /** @test */
    public function a_product_can_return_the_belonging_variant()
    {
        $variant = create(Variant::class, [
            'product_slug' => $this->product->slug,
        ])->first();

        $this->assertEquals(
            $variant->title,
            $this->product->getVariant($variant->original_title)->title
        );
    }

    /** @test */
    public function a_product_will_return_null_if_the_belonging_variant_does_not_exist()
    {
        create(Variant::class, [
            'product_slug' => $this->product->slug,
        ])->first();

        $this->assertEquals(null, $this->product->getVariant('not existing'));
    }

    /** @test */
    public function a_product_can_check_if_variants_do_exist()
    {
        $this->assertFalse($this->product->hasVariants());

        create(Variant::class, [
            'product_slug' => $this->product->slug,
        ])->first();

        $this->assertTrue($this->product->hasVariants());
    }

    /** @test */
    public function we_can_check_if_a_variant_does_exist()
    {
        $this->assertFalse($this->product->variantExists('not existing'));

        $variant = create(Variant::class, [
            'product_slug' => $this->product->slug,
        ])->first();

        $this->assertTrue($this->product->variantExists($variant->original_title));
    }
}
