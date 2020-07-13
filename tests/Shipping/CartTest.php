<?php

namespace Jonassiewertsen\StatamicButik\Tests\Shipping;

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Country as CountryModel;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartTest extends TestCase
{
    use MoneyTrait;

    protected Product $product;
    protected Variant $variant;

    public function setUp(): void {
        parent::setUp();
        $this->product = create(Product::class)->first();
        create(Variant::class, ['product_slug' => $this->product->slug])->first();
        $this->variant = Variant::first();
    }

    /** @test */
    public function a_variant_can_be_added_as_item()
    {
        $this->assertNull(Session::get('butik.cart'));

        Cart::add($this->variant->slug);

        $this->assertCount(1, Cart::get());
    }

    /** @test */
    public function a_new_cart_item_has_the_quanitity_of_one()
    {
        Cart::add($this->product->slug);

        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function the_quanitity_will_be_increased_if_the_product_already_has_been_added()
    {
        Cart::add($this->product->slug);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());

        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function the_quanitity_will_be_increased_if_the_variant_already_has_been_added()
    {
        Cart::add($this->variant->slug);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());

        Cart::add($this->variant->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function a_product_can_be_removed()
    {
        Cart::add($this->product->slug);
        $this->assertTrue(Cart::get()->contains('slug', $this->product->slug));

        Cart::reduce($this->product->slug);
        $this->assertFalse(Cart::get()->contains('slug', $this->product->slug));
    }

    /** @test */
    public function a_variant_can_be_removed()
    {
        Cart::add($this->variant->slug);
        $this->assertTrue(Cart::get()->contains('slug', $this->variant->slug));

        Cart::reduce($this->variant->slug);
        $this->assertFalse(Cart::get()->contains('slug', $this->variant->slug));
    }

    /** @test */
    public function an_product_with_more_then_one_items_will_only_be_decreased()
    {
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::reduce($this->product->slug);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function an_variant_with_more_then_one_items_will_only_be_decreased()
    {
        Cart::add($this->variant->slug);
        Cart::add($this->variant->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::reduce($this->variant->slug);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

    /** @test */
    public function a_product_can_be_completly_removed()
    {
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::remove($this->product->slug);
        $this->assertFalse(Cart::get()->contains('slug', $this->product->slug));
    }

    /** @test */
    public function a_variant_can_be_completly_removed()
    {
        Cart::add($this->variant->slug);
        Cart::add($this->variant->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::remove($this->variant->slug);
        $this->assertFalse(Cart::get()->contains('slug', $this->variant->slug));
    }

    /** @test */
    public function the_cart_can_be_cleared()
    {
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::clear();
        $this->assertTrue((Cart::get() == collect()));
    }

    /** @test */
    public function the_cart_calculates_the_total_price()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = Cart::get()->first();
        $item2 = Cart::get()->last();

        $calculatedPrice = $this->makeAmountSaveable($item1->totalPrice()) + $this->makeAmountSaveable($item2->totalPrice());
        $calculatedPrice = $this->makeAmountHuman($calculatedPrice);

        $this->assertEquals($calculatedPrice, Cart::totalPrice());
    }

    /** @test */
    public function non_sellable_items_will_not_be_counted()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = Cart::get()->first();
        $item1->nonSellable();
        $item2 = Cart::get()->last();

        $this->assertEquals($item2->totalPrice(), Cart::totalPrice());
    }

    /** @test */
    public function we_can_remove_all_non_sellable_items()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = Cart::get()->first();
        $item1->nonSellable();
        $item2 = Cart::get()->last();

        Cart::removeNonSellableItems();

        $this->assertEquals(1, Cart::totalItems());
    }

    /** @test */
    public function the_cart_calculates_total_items()
    {
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create();

        Cart::add($product1->slug); // 1
        Cart::add($product1->slug); // +1
        Cart::add($product2->slug); // 2 + 1

        $this->assertEquals(3, Cart::totalItems());
    }

    /** @test */
    public function the_cart_returns_zero_without_any_items()
    {
        Cart::clear();

        $this->assertNotNull(Cart::totalItems());
    }

    /** @test */
    public function the_default_country_will_automatically_be_set()
    {
        $country = create(CountryModel::class)->first();
        Config::set('butik.country', $country->slug);

        $this->assertEquals(Cart::country()['name'], $country->name);
    }

    /** @test */
    public function we_can_set_any_country_we_want()
    {
        $country = create(CountryModel::class)->first();
        Cart::setCountry($country->slug);

        $this->assertEquals(Cart::country()['name'], $country->name);
    }
}
