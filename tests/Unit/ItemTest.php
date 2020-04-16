<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

class ItemTest extends TestCase
{
    use \Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

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

    /** @test */
    public function an_item_can_be_increased()
    {
        $item = new Item($this->product);
        $item->increase();

        $this->assertEquals($item->quantity, 2);
    }

    /** @test */
    public function an_item_can_be_decreased()
    {
        $item = new Item($this->product);
        $item->quantity = 2;

        $item->decrease();

        $this->assertEquals($item->quantity, 1);
    }

    /** @test */
    public function an_item_quantity_cant_be_lover_then_one()
    {
        $item = new Item($this->product);
        $item->decrease();

        $this->assertEquals($item->quantity, 1);
    }

    /** @test */
    public function an_item_has_a_total_price()
    {
        $item = new Item($this->product);

        $this->assertEquals($this->product->totalPrice, $item->total);
    }

    /** @test */
    public function multiple_prices_will_be_added_up_by_the_given_quantity()
    {
        $item = new Item($this->product);
        $item->quantity(3);

        $productPrice = $this->makeAmountSaveable($this->product->totalPrice);
        $total = $this->makeAmountHuman($productPrice * 3);

        $this->assertEquals($total, $item->totalPrice());
    }
}
