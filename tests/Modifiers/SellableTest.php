<?php

namespace Jonassiewertsen\StatamicButik\Tests\Modifiers;

use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Modifiers\Sellable;

use Jonassiewertsen\StatamicButik\Tests\TestCase;
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
