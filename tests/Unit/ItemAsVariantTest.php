<?php

namespace Jonassiewertsen\Butik\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Jonassiewertsen\Butik\Checkout\Item;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Http\Models\Product as ProductModel;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Jonassiewertsen\Butik\Tests\TestCase;

class ItemAsVariantTest extends TestCase
{
    protected ProductModel $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();

        create(Variant::class, [
            'product_slug' => $this->product->slug,
        ])->first();

        $this->variant = Variant::first();
    }

    /** @test */
    public function it_has_a_id()
    {
        $this->withoutexceptionhandling();
        $item = new Item($this->variant->slug);

        $this->assertEquals($item->slug, $this->variant->slug);
    }

    /** @test */
    public function it_has_a_taxRate()
    {
        $item = new Item($this->variant->slug);

        $this->assertEquals($item->taxRate, $this->variant->tax->percentage);
    }

    /** @test */
    public function it_has_a_name()
    {
        $item = new Item($this->variant->slug);

        $this->assertEquals($item->name, $this->variant->title);
    }

    /** @test */
    public function it_can_be_sellable()
    {
        $item = new Item($this->variant->slug);

        $this->assertTrue($item->sellable);
    }

    /** @test */
    public function it_can_be_declared_as_sellable()
    {
        $item = new Item($this->variant->slug);
        $item->sellable();

        $this->assertTrue($item->sellable);
    }

    /** @test */
    public function it_can_be_declared_as_non_sellable()
    {
        $item = new Item($this->variant->slug);
        $item->nonSellable();

        $this->assertFalse($item->sellable);
    }

    /** @test */
    public function it_has_a_description()
    {
        $item = new Item($this->variant->slug);

        $this->assertEquals($item->description, Str::limit($this->product->description, 100));
    }

    /** @test */
    public function it_has_a_default_quanitity_of_1()
    {
        $item = new Item($this->variant->slug);

        $this->assertEquals($item->getQuantity(), 1);
    }

    /** @test */
    public function an_item_can_be_increased()
    {
        $item = new Item($this->variant->slug);
        $item->increase();

        $this->assertEquals($item->getQuantity(), 2);
    }

    /** @test */
    public function an_item_can_max_increases_to_the_avialable_stock()
    {
        $this->variant->update(['stock' => 1]);
        $item = new Item($this->variant->slug);
        $item->increase();

        $this->assertEquals(1, $item->getQuantity());
    }

    /** @test */
    public function an_item_can_be_decreased()
    {
        $item = new Item($this->variant->slug);
        $item->setQuantity(2);

        $item->decrease();

        $this->assertEquals($item->getQuantity(), 1);
    }

    /** @test */
    public function an_item_quantity_cant_be_lover_then_one()
    {
        $item = new Item($this->variant->slug);
        $item->decrease();

        $this->assertEquals($item->getQuantity(), 1);
    }

    /** @test */
    public function an_item_has_a_total_price()
    {
        $item = new Item($this->variant->slug);

        $this->assertEquals($this->variant->price, $item->totalPrice());
    }

    /** @test */
    public function multiple_prices_will_be_added_up_by_the_given_quantity()
    {
        $item = new Item($this->variant->slug);
        $item->setQuantity(3);

        $total = Price::of($this->variant->price)->cents() * 3;

        $this->assertEquals(Price::of($total->get()), $item->totalPrice());
    }

    /** @test */
    public function A_new_single_price_will_be_reflected_on_the_item_update()
    {
        $item = new Item($this->variant->slug);

        $newPrice = 9999;
        $this->variant->update(['price' => $newPrice]);
        Cache::flush();
        $item->update();

        $this->assertEquals($item->singlePrice(), $this->variant->price);
    }

    /** @test */
    public function A_new_total_price_will_be_reflected_on_the_item_update()
    {
        $this->variant->inherit_price = false;
        $item = new Item($this->variant->slug);

        $oldPrice = $item->totalPrice();
        $this->variant->update(['price' => 999]);
        Cache::flush();
        $item->update();

        $this->assertNotEquals($item->totalPrice(), $oldPrice);
    }

    /** @test */
    public function A_non_available_item_will_be_set_to_null()
    {
        $item = new Item($this->variant->slug);

        $this->variant->update(['available' => false]);

        Cache::flush();
        $item->update();

        $this->assertEquals(0, $item->getQuantity());
    }

    /** @test */
    public function it_has_a_shipping_profile()
    {
        $item = new Item($this->variant->slug);

        Cache::flush();
        $item->update();

        $this->assertEquals(ShippingProfile::first(), $item->shippingProfile);
    }
}
