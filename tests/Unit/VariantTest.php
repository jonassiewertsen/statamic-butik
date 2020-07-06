<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class VariantTest extends TestCase
{
    public Variant $variant;
    public Product $product;

    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
        $this->variant = create(Variant::class)->first();
        $this->product = Product::first();
    }

    /** @test */
    public function a_variant_belongs_to_a_product()
    {
        $this->assertInstanceOf(Product::class, $this->variant->product);
    }

    /** @test */
    public function a_variant_has_title()
    {
        $this->assertEquals(
            $this->variant->title,
            $this->product->title . ' - ' . $this->variant->getRawOriginal('title')
        );
    }

    /** @test */
    public function a_variant_has_a_original_title()
    {
        $this->assertEquals(
            $this->variant->original_title,
            $this->variant->getRawOriginal('title')
        );
    }

    /** @test */
    public function the_price_can_be_inherited_from_the_parent()
    {
        $this->assertEquals(
            $this->variant->price,
            $this->product->title . ' - ' . $this->variant->getRawOriginal('title')
        );
    }

    /** @test */
    public function a_variant_has_a_original_price()
    {
        $this->assertEquals(
            $this->variant->original_price,
            $this->variant->getOriginal('price')
        );
    }

    /** @test */
    public function a_variant_can_inherit_its_parent_price()
    {
        $this->variant->inherit_price = true;

        $this->assertEquals(
            $this->product->price,
            $this->variant->price,
        );
    }

    /** @test */
    public function a_variant_can_have_its_own_price_price()
    {
        $this->variant->inherit_price = false;
        $this->variant->price = '33,00';
        $this->variant->update();

        $this->assertEquals(
            '33,00',
            $this->variant->price,
        );
    }

       /** @test */
    public function the_price_will_be_converted_correctly()
    {
        $product = create(Variant::class, ['price' => 2]);
        $this->assertEquals('2,00', $product->first()->price);
    }

    /** @test */
    public function the_price_will_be_saved_without_decimals()
    {
        create(Variant::class, ['price' => '2,00']);
        $this->assertEquals('200', Variant::first()->getRawOriginal('price'));
    }

    /** @test */
    public function the_stock_has_a_original_amount()
    {
        $this->assertEquals(
            $this->variant->original_stock,
            $this->variant->getRawOriginal('stock')
        );
    }

    /** @test */
    public function the_stock_can_inherit_its_parent_stock()
    {
        $this->variant->inherit_stock = true;

        $this->assertEquals(
            $this->product->stock,
            $this->variant->stock,
        );
    }

    /** @test */
    public function the_stock_can_have_its_own_stock_amount()
    {
        $this->variant->inherit_stock = false;
        $this->variant->stock = 15;
        $this->variant->update();

        $this->assertEquals(
            15,
            $this->variant->stock,
        );
    }

    /** @test */
    public function the_stock_unlimited_has_a_original_amount()
    {
        $this->assertEquals(
            $this->variant->original_stock_unlimited,
            $this->variant->getRawOriginal('stock_unlimited')
        );
    }

    /** @test */
    public function the_stock_unlimited_can_inherit_its_parent_stock()
    {
        $this->variant->inherit_stock = true;
        $this->variant->stock_unlimited = true;
        $this->variant->update();

        $this->assertEquals(
            $this->product->stock_unlimited,
            $this->variant->stock_unlimited,
        );
    }

    /** @test */
    public function the_stock_unlimited_can_have_its_own_stock_amount()
    {
        $this->variant->inherit_stock = false;
        $this->variant->stock_unlimited = true;
        $this->variant->update();

        $this->assertTrue($this->variant->stock_unlimited);
    }


}
