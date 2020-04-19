<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CheckoutPaymentTest extends TestCase
{
    protected Customer  $customer;
    protected Product   $product;

    public function setUp(): void {
        parent::setUp();

        $this->customer = new Customer($this->createUserData());
        $this->product  = create(Product::class)->first();
    }

    /** @test */
    public function the_pament_view_will_be_shown()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertOk()
            ->assertViewIs(config('butik.template_checkout-payment'));
    }

    /** @test */
    public function translations_will_be_displayed_on_the_ship_to_card()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
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
    public function translations_will_be_displayed_on_product_cards()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertSee('Delivery')
            ->assertSee('Review &amp; Payment')
            ->assertSee('Receipt')
            ->assertSee('Shipping')
            ->assertSee('Total');
    }

    /** @test */
    public function the_payment_process_button_to_redirect_to_mollies_will_be_shown(){
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.express.payment', $this->product))
            ->assertOk()
            ->assertSee(route('butik.payment.process', $this->product));
    }

    // TODO: Tests to remove products from the cart, which are sold out.

    // TODO: Tests to remove products from the cart, which are not available.

    /** @test */
    public function the_payment_page_will_redirect_if_the_cart_is_empty() {
        $this->withoutExceptionHandling();
        Session::put('butik.cart', null);

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_name() {
        $this->withoutExceptionHandling();
        Session::put('butik.customer', new Customer($this->createUserData('name', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_mail() {
        Session::put('butik.customer', new Customer($this->createUserData('mail', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_country() {
        Session::put('butik.customer', new Customer($this->createUserData('country', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_address_1() {
        Session::put('butik.customer', new Customer($this->createUserData('address1', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_city() {
        Session::put('butik.customer', new Customer($this->createUserData('city', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_zip() {
        Session::put('butik.customer', new Customer($this->createUserData('zip', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

// TODO: The products need to be displayed
//    /** @test */
//    public function the_product_information_will_be_displayed(){
//        Session::put('butik.customer', $this->customer);
//
//        $this->get(route('butik.checkout.express.payment', $this->product))
//            ->assertOk()
//            ->assertSee($this->product->title)
//            ->assertSee($this->product->base_price)
//            ->assertSee($this->product->total_price)
//            ->assertSee($this->product->taxes_amount)
//            ->assertSee($this->product->taxes_percentage)
//            ->assertSee($this->product->shipping_amount);
//    }

    /** @test */
    public function customer_data_will_be_displayed_inside_the_view() {
        Session::put('butik.customer', $this->customer);
        $customer = (array) $this->customer;

        $this->get(route('butik.checkout.payment'))
            ->assertSee($customer['name'])
            ->assertSee($customer['mail'])
            ->assertSee($customer['address1'])
            ->assertSee($customer['address2'])
            ->assertSee($customer['city'])
            ->assertSee($customer['zip'])
            ->assertSee($customer['country']);
    }

    private function createUserData($key = null, $value = null): array {
        $customer = [
            'country' => 'Germany',
            'name' => 'John Doe',
            'mail' => 'johndoe@mail.de',
            'address1' => 'Main Street 2',
            'address2' => '',
            'city' => 'Flensburg',
            'state_region' => '',
            'zip' => '24579',
            'phone' => '013643-23837'
        ];

        if ($key !== null || $value !== null) {
            $customer[$key] = $value;
        }

        return $customer;
    }
}
