<?php

namespace Tests\Cart;

use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Contracts\PriceCalculator;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Contracts\TaxCalculator;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    public ProductRepository $product;
    public Item $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->makeTax();
        $this->product = $this->makeProduct();
        $this->item = new Item($this->product, 2);
    }

    /** @test */
    public function it_has_availability()
    {
        $this->assertTrue($this->item->isAvailable());
    }

    /** @test */
    public function it_has_a_slug()
    {
        $this->assertEquals($this->item->slug, $this->product->slug);
    }

    /** @test */
    public function it_has_a_product()
    {
        $this->assertInstanceOf(ProductRepository::class, $this->item->product);
    }

    /** @test */
    public function is_has_a_default_quantity_of_zero()
    {
        $item = new Item($this->product);
        $this->assertEquals(1, $item->quantity());
    }

    /** @test */
    public function the_price_is_a_price_calculator_instance()
    {
        $this->assertInstanceOf(PriceCalculator::class, $this->item->price());
    }

    /** @test */
    public function it_has_a_tax_calculator_instance()
    {
        $this->assertInstanceOf(TaxCalculator::class, $this->item->tax());
    }

    /** @test */
    public function it_is_sellable_by_default()
    {
        $this->assertTrue($this->item->isSellable());
    }

    /** @test */
    public function it_can_change_it_sellable_status()
    {
        $this->assertTrue($this->item->isSellable());
        $this->item->nonSellable();
        $this->assertFalse($this->item->isSellable());
        $this->item->sellable();
        $this->assertTrue($this->item->isSellable());
    }

    /** @test */
    public function it_has_a_available_stock()
    {
        $this->assertEquals(5, $this->item->stock());
    }

    /** @test */
    public function the_stock_can_not_be_unlimited()
    {
        $this->assertFalse($this->item->stockUnlimited());
    }

    /** @test */
    public function the_stock_can_be_unlimited()
    {
        $product = $this->makeProduct(['stock_unlimited' => true]);

        $item = new Item($product);

        $this->assertTrue($item->stockUnlimited());
    }
}
