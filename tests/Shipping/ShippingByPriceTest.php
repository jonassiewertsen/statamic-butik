<?php

namespace TestsShipping;

use Jonassiewertsen\Butik\Checkout\Cart;
use Jonassiewertsen\Butik\Facades\Price;
use Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;
use Jonassiewertsen\Butik\Shipping\ShippingByPrice;
use Tests\TestCase;
use Statamic\Facades\Entry;

class ShippingByPriceTest extends TestCase
{
    public Product $productWithFreeShipping1;
    public Product $productWithShippingCots;
    public Product $productWithFreeShipping2;

    public function setUp(): void
    {
        parent::setUp();

        $shippingZone = create(ShippingZone::class)->first();
        create(ShippingProfile::class)->first();

        $this->productWithFreeShipping1 = $this->makeProduct();
        $this->productWithFreeShipping2 = $this->makeProduct();
        $this->productWithShippingCots = $this->makeProduct([], $shippingZone, false);

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'title'            => 'Standard',
            'minimum'          => 0,
            'price'            => '6,00',
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => $shippingZone->id,
            'title'            => 'Free',
            'minimum'          => 50,
            'price'            => 0,
        ]);
    }

    /** @test */
    public function the_correct_total_item_value_will_be_calculated()
    {
        Cart::add($this->productWithFreeShipping1->slug);
        Cart::add($this->productWithShippingCots->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());
        $shipping->calculate();

        $total = Price::of($this->productWithFreeShipping1->price)
                        ->add($this->productWithShippingCots->price)
                        ->cents();

        $this->assertEquals($total, $shipping->summedItemValue);
    }

    /** @test */
    public function the_standard_shipping_rate_will_be_selected()
    {
        $product = Entry::findBySlug($this->productWithShippingCots->slug, 'products');
        $product->set('price', '49.99')->save();

        Cart::add($this->productWithShippingCots->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('6,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_standard_shipping_rate_wont_be_used_if_the_amount_does_match()
    {
        $product = Entry::findBySlug($this->productWithFreeShipping1->slug, 'products');
        $product->set('price', '50.00')->save();

        Cart::add($this->productWithFreeShipping1->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_free_shipping_amount_will_be_calculated()
    {
        Cart::add($this->productWithFreeShipping1->slug);
        Cart::add($this->productWithShippingCots->slug);
        Cart::add($this->productWithFreeShipping2->slug);

        $shipping = new ShippingByPrice();
        $shipping->set(Cart::get(), ShippingZone::first());

        $this->assertEquals('0,00', $shipping->calculate()->total);
    }

    /** @test */
    public function the_cart_will_output_the_correct_amount()
    {
        $product = Entry::findBySlug($this->productWithShippingCots->slug, 'products');
        $product->set('price', '4.00')->save();

        Cart::add($this->productWithShippingCots->slug);
        $shipping = Cart::shipping();

        $this->assertEquals('6,00', $shipping->first()->total);
    }

    /** @test */
    public function the_cart_does_return_the_total_shipping_amount()
    {
        $product = Entry::findBySlug($this->productWithShippingCots->slug, 'products');
        $product->set('price', '4.00')->save();

        Cart::add($this->productWithShippingCots->slug);
        $total = Cart::totalShipping();

        $this->assertEquals('6,00', $total);
    }
}
