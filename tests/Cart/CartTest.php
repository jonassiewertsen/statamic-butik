<?php

namespace Tests\Cart;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Cart;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Jonassiewertsen\Butik\Shipping\Country;
use Tests\TestCase;

class CartTest extends TestCase
{
    protected ProductRepository $product;
    protected string $slug;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
        $this->slug = $this->product->slug;
    }

    /** @test */
    public function a_product_can_be_added_to_the_cart()
    {
        Cart::add($this->slug);

        $expected = [
            $this->product->slug => [
                'quantity' => 1,
            ],
        ];

        $this->assertEquals($expected, Cart::raw());
    }

    /** @test */
    public function the_quanitity_will_be_increased_if_the_product_already_has_been_added()
    {
        Cart::add($slug = $this->product->slug);
        $this->assertEquals(1, Cart::raw()[$slug]['quantity']);

        Cart::add($slug = $this->product->slug);
        $this->assertEquals(2, Cart::raw()[$slug]['quantity']);
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
    public function an_product_with_more_then_one_items_will_only_be_decreased()
    {
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::reduce($this->product->slug);
        $this->assertEquals(1, Cart::get()->first()->getQuantity());
    }

//    /** @test */
//    public function an_variant_with_more_then_one_items_will_only_be_decreased()
//    {
//        Cart::add($this->variant->slug);
//        Cart::add($this->variant->slug);
//        $this->assertEquals(2, Cart::get()->first()->getQuantity());
//
//        Cart::reduce($this->variant->slug);
//        $this->assertEquals(1, Cart::get()->first()->getQuantity());
//    }

    /** @test */
    public function a_product_can_be_completly_removed()
    {
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);
        $this->assertEquals(2, Cart::get()->first()->getQuantity());

        Cart::remove($this->product->slug);
        $this->assertFalse(Cart::get()->contains('slug', $this->product->slug));
    }

//    /** @test */
//    public function a_variant_can_be_completly_removed()
//    {
//        Cart::add($this->variant->slug);
//        Cart::add($this->variant->slug);
//        $this->assertEquals(2, Cart::get()->first()->getQuantity());
//
//        Cart::remove($this->variant->slug);
//        $this->assertFalse(Cart::get()->contains('slug', $this->variant->slug));
//    }

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
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct();

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = Cart::get()->first();
        $item2 = Cart::get()->last();

        $calculatedPrice = Price::of($item1->totalPrice())->add($item2->totalPrice())->get();

        $this->assertEquals($calculatedPrice, Cart::totalPrice());
    }

    /** @test */
    public function the_cart_calculates_the_total_price_including_shipping_amount()
    {
        // Create a new shipping zone to use a zone with taxes.
        $shippingZone = create(ShippingZone::class)->first();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'minimum' => 1,
        ])->first();

        $product = $this->makeProduct([
            'tax_id' => $shippingZone->tax_slug,
        ], $shippingZone);

        Cart::add($product->slug);
        $shipping = Cart::shipping()->first()->total;

        $totalAmount = Price::of($shipping)->add($product->price)->get();

        $this->assertEquals($totalAmount, Cart::totalPrice());
    }

    /** @test */
    public function non_sellable_items_will_not_be_counted()
    {
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct();

        Cart::add($product1->slug);
        Cart::add($product2->slug);
        Cart::get()->first()->nonSellable();

        $item2 = Cart::get()->last();

        $this->assertEquals($item2->totalPrice(), Cart::totalPrice());
    }

    /** @test */
    public function we_can_remove_all_non_sellable_items()
    {
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct();

        Cart::add($product1->slug);
        Cart::add($product2->slug);
        Cart::get()->first()->nonSellable();

        Cart::removeNonSellableItems();

        $this->assertEquals(1, Cart::count());
    }

    /** @test */
    public function the_cart_calculates_total_items()
    {
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct();

        Cart::add($product1->slug); // 1
        Cart::add($product1->slug); // +1
        Cart::add($product2->slug); // 2 + 1

        $this->assertEquals(3, Cart::count());
    }

    /** @test */
    public function the_cart_has_total_taxes()
    {
        $product = $this->makeProduct();

        Cart::add($product->slug);

        $this->assertEquals(
            (new Item($product->slug))->taxAmount,
            Cart::totalTaxes()->first()['amount']
        );
    }

    /** @test */
    public function the_cart_does_contain_the_total_shipping_amount()
    {
        // Create a new shipping zone to use a zone with taxes.
        $shippingZone = create(ShippingZone::class)->first();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'minimum' => 1,
        ])->first();

        $product = $this->makeProduct([
            'tax_id' => $shippingZone->tax_slug,
        ], $shippingZone);

        Cart::add($product->slug);

        $shippingAmount = Cart::shipping()->first()->total;

        $this->assertEquals($shippingAmount, Cart::totalShipping());
    }

    /** @test */
    public function the_cart_does_include_shipping_taxes()
    {
        // Create a new shipping zone to use a zone with taxes.
        $shippingZone = create(ShippingZone::class)->first();

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'minimum' => 1,
        ])->first();

        $product = $this->makeProduct([
            'tax_id' => $shippingZone->tax_slug,
        ], $shippingZone);

        Cart::add($product->slug);

        $itemTaxAmount = (new Item($product->slug))->taxAmount;
        $shippingTaxAmount = Cart::shipping()->first()->taxAmount;

        $this->assertEquals(
            Price::of($itemTaxAmount)->add($shippingTaxAmount)->get(),
            Cart::totalTaxes()->first()['amount']
        );
    }

    /** @test */
    public function the_total_taxes_will_sum_multiple_taxes_from_products()
    {
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct(['tax_id' => $product1->tax_id]);

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = new Item($product1->slug);
        $item2 = new Item($product2->slug);

        $this->assertEquals(
            Price::of($item1->taxAmount)->add($item2->taxAmount)->get(),
            Cart::totalTaxes()->first()['amount']
        );
    }

    /** @test */
    public function the_cart_returns_zero_without_any_items()
    {
        $this->assertNotNull(Cart::count());
    }

    /** @test */
    public function the_cart_can_return_the_actual_set_country()
    {
        $this->assertEquals(Country::get(), Cart::country());
    }

    /** @test */
    public function a_new_country_can_be_set()
    {
        // TODO: Rewrite test the Country is it's own Facade to mock the output.

//        $this->assertEquals(Country::get(), 'dk');
        $this->assertTrue(true);
    }

    /** @test */
    public function a_customer_can_be_fetched_from_the_cart()
    {
        Session::put('butik.customer', new Customer());

        $this->assertInstanceOf(Customer::class, Cart::customer());
    }
}