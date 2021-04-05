<?php

namespace Tests\Cart;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Cart\ItemCollection;
use Jonassiewertsen\Butik\Contracts\ProductRepository;
use Jonassiewertsen\Butik\Facades\Cart;
use Jonassiewertsen\Butik\Facades\Country;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Http\Responses\CartResponse;
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
    public function an_added_product_will_be_saved_as_an_array()
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
    public function a_product_can_be_added()
    {
        Cart::add($this->slug);

        $this->assertCount(1, Cart::get());
    }

    /** @test */
    public function if_added_correctly_an_cart_response_will_be_returned()
    {
        $this->assertInstanceOf(CartResponse::class, Cart::add($this->slug));

        $this->assertCount(1, Cart::get());
    }

    /** @test */
    public function it_can_return_a_item_collection()
    {
        Cart::add($this->slug);

        $this->assertInstanceOf(ItemCollection::class, Cart::get());
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
        $this->assertTrue(Cart::contains($this->product->slug));

        Cart::remove($this->product->slug);
        $this->assertFalse(Cart::contains($this->product->slug));
    }

    /** @test */
    public function its_product_quantity_can_be_updated()
    {
        Cart::add($this->product->slug, 2);
        $this->assertEquals(2, Cart::get()->first()->quantity());

        Cart::update($this->product->slug, 1);
        $this->assertEquals(1, Cart::get()->first()->quantity());
    }

    /** @test */
    public function a_products_quantity_cant_be_higher_than_its_stock_if_added_to_the_cart()
    {
        $response = Cart::add($this->product->slug, 99);
        $this->assertFalse($response::$success);
    }

    /** @test */
    public function a_products_quantity_cant_be_higher_than_its_stock_if_update_on_the_cart()
    {
        Cart::add($this->product->slug);

        $response = Cart::update($this->product->slug, 99);
        $this->assertFalse($response::$success);
    }

    /** @test */
    public function a_product_can_be_completly_removed()
    {
        Cart::add($this->product->slug);
        $this->assertCount(1, Cart::get());

        Cart::remove($this->product->slug);
        $this->assertCount(0, Cart::get());
    }

    /** @test */
    public function the_cart_can_be_cleared()
    {
        Cart::add($this->product->slug);
        $this->assertCount(1, Cart::get());

        Cart::clear();
        $this->assertCount(0, Cart::get());
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

        $calculatedPrice = Price::of($item1->price()->get())->add($item2->price()->get());

        $this->assertEquals($calculatedPrice, Cart::totalPrice());
    }

    /** @test */
    public function the_cart_calculates_the_total_price_including_shipping_amount()
    {
        // TODO: Calculate shipping
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
    public function non_sellable_items_will_not_get_counted()
    {
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct();

        Cart::add($product1->slug);
        Cart::add($product2->slug);
        Cart::get()->first()->nonSellable();

        $item2 = Cart::get()->last();

        $this->assertEquals($item2->price()->total(), Cart::totalPrice());
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
        $this->makeTax();
        $product = $this->makeProduct();

        Cart::add($product->slug);

        $this->assertEquals(
            (new Item($product->slug))->tax()->total()->get(),
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
        $this->makeTax();
        $product1 = $this->makeProduct();
        $product2 = $this->makeProduct(['tax_id' => $product1->tax_id]);

        Cart::add($product1->slug);
        Cart::add($product2->slug);

        $item1 = new Item($product1->slug);
        $item2 = new Item($product2->slug);

        $this->assertEquals(
            Price::of($item1->tax()->total())->add($item2->tax()->total())->get(),
            Cart::totalTaxes()->first()['amount']
        );
    }

    /** @test */
    public function the_cart_returns_zero_without_any_items()
    {
        $this->assertTrue(Cart::count() === 0);
    }

    /** @test */
    public function the_cart_can_return_the_actual_set_country()
    {
        $this->assertEquals(Country::iso(), Cart::country());
    }

    /** @test */
    public function a_new_country_can_be_set()
    {
        Cart::setCountry('DK');

        $this->assertEquals(Cart::country(), 'DK');
    }

    /** @test */
    public function a_customer_can_be_fetched_from_the_cart()
    {
        Session::put('butik.customer', new Customer());

        $this->assertInstanceOf(Customer::class, Cart::customer());
    }
}
