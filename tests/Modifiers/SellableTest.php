<?php

namespace TestsModifiers;

use Jonassiewertsen\Butik\Checkout\Item;
use Jonassiewertsen\Butik\Modifiers\Sellable;
use Tests\TestCase;
use Statamic\Modifiers\Modifier;

class SellableTest extends TestCase
{
    protected Modifier $modifier;

    public function setUp(): void
    {
        parent::setUp();

        $this->modifier = new Sellable();
    }

    /** @test */
    public function a_product_can_be_sellable()
    {
        $product = $this->makeProduct();
        $item = new Item($product->slug);

        $this->assertTrue($this->modifier->index([(array) $item], null, null));
    }

    /** @test */
    public function a_product_can_be_not_sellable()
    {
        $product = $this->makeProduct();
        $item = new Item($product->slug);
        $item->nonSellable();

        $this->assertFalse($this->modifier->index([(array) $item], null, null));
    }
}
