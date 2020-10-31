<?php

namespace Jonassiewertsen\StatamicButik\Tests\Modifiers;

use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Modifiers\Sellable;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class SellableTest extends TestCase
{
    /** @test */
    public function a_product_can_be_sellable()
    {
        $product = $this->makeProduct();
        $item = new Item($product->slug);

        $this->assertTrue((new Sellable())->index([(array) $item], null, null));
    }

    /** @test */
    public function a_product_can_be_not_sellable()
    {
        $product = $this->makeProduct();
        $item = new Item($product->slug);
        $item->nonSellable();

        $this->assertFalse((new Sellable())->index([(array) $item], null, null));
    }
}
