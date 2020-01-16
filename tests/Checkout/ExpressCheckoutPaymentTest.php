<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutPaymentTestTest extends TestCase
{
    protected $product;

    public function setUp(): void {
        parent::setUp();

        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_name() {
        Session::put('butik.customer', $this->createUserData('name', ''));

        $this->get($this->product->expressPaymentUrl())
           ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function translations_will_be_displayed(){
        Session::put('butik.customer', $this->createUserData());

        $this->get(route('butik.checkout.express.payment', $this->product))
            ->assertSee('Delivery')
            ->assertSee('Review & Payment')
            ->assertSee('Receipt')
            ->assertSee('Subtotal')
            ->assertSee('Shipping')
            ->assertSee('Total')
            ->assertSee('Ship to')
            ->assertSee('Pay now & confirm')
            ->assertSee('Name')
            ->assertSee('Mail')
            ->assertSee('Country')
            ->assertSee('Address 1')
            ->assertSee('City')
            ->assertSee('Zip');
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_mail() {
        Session::put('butik.customer', $this->createUserData('mail', ''));

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_country() {
        Session::put('butik.customer', $this->createUserData('country', ''));

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_address_1() {
        Session::put('butik.customer', $this->createUserData('address_1', ''));

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_city() {
        Session::put('butik.customer', $this->createUserData('city', ''));

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_zip() {
        Session::put('butik.customer', $this->createUserData('zip', ''));

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function The_express_payment_page_does_exist()
    {
        Session::put('butik.customer', $this->createUserData());
        $route = $this->product->expressPaymentUrl();

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.express.payment', $route);
    }

    /** @test */
    public function the_product_information_will_be_displayed(){
        Session::put('butik.customer', $this->createUserData());

        $this->get($this->product->expressPaymentUrl())
            ->assertSee($this->product->title)
            ->assertSee($this->product->base_price);
    }

    /** @test */
    public function customer_data_will_be_displayed_inside_the_view() {
        Session::put('butik.customer',$customer = $this->createUserData());

        $this->get(route('butik.checkout.express.payment', $this->product))
            ->assertSee($customer['name'])
            ->assertSee($customer['mail'])
            ->assertSee($customer['address_1'])
            ->assertSee($customer['address_2'])
            ->assertSee($customer['city'])
            ->assertSee($customer['zip']);
    }

    private function createUserData($key = null, $value = null) {
        $data = [
            'country' => 'Germany',
            'name' => 'John Doe',
            'mail' => 'johndoe@mail.de',
            'address_1' => 'Main Street 2',
            'address_2' => '',
            'city' => 'Flensburg',
            'state_region' => '',
            'zip' => '24579',
            'phone' => '013643-23837'
        ];

        if ($key !== null || $value !== null) {
            $data[$key] = $value;
        }

        return $data;
    }
}
