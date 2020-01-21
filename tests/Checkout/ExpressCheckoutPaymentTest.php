<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutPaymentTestTest extends TestCase
{
    protected $cart;

    public function setUp(): void {
        parent::setUp();

        $this->cart = (new Cart)
            ->customer($this->createUserData())
            ->addProduct((create(Product::class)->first()));
    }

    /** @test */
    public function translations_will_be_displayed(){
        Session::put('butik.cart', $this->cart->customer($this->createUserData()));

        $this->get(route('butik.checkout.express.payment'))
            ->assertOk()
            ->assertSee('Delivery')
            ->assertSee('Review & Payment')
            ->assertSee('Receipt')
            ->assertSee('Subtotal')
            ->assertSee('Shipping')
            ->assertSee('Total')
            ->assertSee('Ship to')
            ->assertSee('Go to payment')
            ->assertSee('Name')
            ->assertSee('Mail')
            ->assertSee('Country')
            ->assertSee('Address 1')
            ->assertSee('City')
            ->assertSee('Zip');
    }

    /** @test */
    public function the_payment_page_will_redirect_if_the_product_is_sold_out() {
        $this->cart->products->first()->stock = 0;
        Session::put('butik.cart', $this->cart);

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->showUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_if_the_product_is_not_available() {
        $this->cart->products->first()->available = false;
        Session::put('butik.cart', $this->cart);

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->showUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_in_case_the_session_does_not_exist() {
        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect(route('butik.shop'));
    }

    /** @test */
    public function the_payment_page_will_redirect_if_no_product_is_in_the_cart() {
        $this->cart->products = null;
        Session::put('butik.cart', $this->cart);

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect(route('butik.shop'));
    }

    /** @test */
    public function the_payment_page_will_redirect_if_more_then_one_product_is_in_the_cart() {
        $this->cart->products = create(Product::class, [], 2);
        Session::put('butik.cart', $this->cart);

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect(route('butik.shop'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_name() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('name', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_mail() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('mail', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_country() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('country', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_address_1() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('address1', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_city() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('city', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_zip() {
        Session::put('butik.cart', $this->cart->customer($this->createUserData('zip', '')));

        $this->get(route('butik.checkout.express.payment'))
            ->assertRedirect($this->cart->products->first()->expressDeliveryUrl);
    }

    /** @test */
    public function The_express_payment_page_does_exist()
    {
        Session::put('butik.cart', $this->cart->customer($this->createUserData()));
        $route = route('butik.checkout.express.payment');

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.express.payment', $route);
    }

    /** @test */
    public function the_product_information_will_be_displayed(){
        $this->withoutExceptionHandling();
//        $product = create(Product::class)->first();
        Session::put('butik.cart', $this->cart);
        $product = $this->cart->products->first();

        $this->get(route('butik.checkout.express.payment'))
            ->assertOk()
            ->assertSee($product->title)
            ->assertSee($product->base_price)
            ->assertSee($product->total_price)
            ->assertSee($product->taxes_amount)
            ->assertSee($product->taxes_percentage)
            ->assertSee($product->shipping_amount);
    }

    /** @test */
    public function customer_data_will_be_displayed_inside_the_view() {
        Session::put('butik.cart', $this->cart);
        $customer = (array) $this->cart->customer;

        $this->get(route('butik.checkout.express.payment', (array) $customer))
            ->assertSee($customer['name'])
            ->assertSee($customer['mail'])
            ->assertSee($customer['address1'])
            ->assertSee($customer['address2'])
            ->assertSee($customer['city'])
            ->assertSee($customer['zip'])
            ->assertSee($customer['country']);
    }

    private function createUserData($key = null, $value = null) {
        $customer = (new Customer)->create([
            'country' => 'Germany',
            'name' => 'John Doe',
            'mail' => 'johndoe@mail.de',
            'address1' => 'Main Street 2',
            'address2' => '',
            'city' => 'Flensburg',
            'state_region' => '',
            'zip' => '24579',
            'phone' => '013643-23837'
        ]);

        if ($key !== null || $value !== null) {
            $customer->$key = $value;
        }

        return $customer;
    }
}
