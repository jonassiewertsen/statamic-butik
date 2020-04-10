<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ItemTest extends TestCase
{
    protected Product $product;

    public function setUp(): void {
        parent::setUp();

        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function it_has_a_id()
    {
        $item = new Item($this->product);

        $this->assertEquals($item->id, $this->product->slug);
    }

    /** @test */
    public function it_has_a_product()
    {
        $item = new Item($this->product);

        $this->assertEquals($item->product, $this->product);
    }

    /** @test */
    public function it_has_a_name()
    {
        $item = new Item($this->product);

        $this->assertEquals($item->name, $this->product->title);
    }

    /** @test */
    public function it_has_a_default_quanitity_of_1()
    {
        $item = new Item($this->product);

        $this->assertEquals($item->quantity, 1);
    }
}
