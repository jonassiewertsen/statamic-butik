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
        $customer = $this->createUserData('name', '');
        Session::put('butik.customer', $customer);

        $this->get($this->product->expressPaymentUrl())
           ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_mail() {
        $customer = $this->createUserData('mail', '');
        Session::put('butik.customer', $customer);

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_country() {
        $customer = $this->createUserData('country', '');
        Session::put('butik.customer', $customer);

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_address_1() {
        $customer = $this->createUserData('address_1', '');
        Session::put('butik.customer', $customer);

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_city() {
        $customer = $this->createUserData('city', '');
        Session::put('butik.customer', $customer);

        $this->get($this->product->expressPaymentUrl())
            ->assertRedirect($this->product->expressDeliveryUrl());
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_zip() {
        $customer = $this->createUserData('zip', '');
        Session::put('butik.customer', $customer);

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
        $customer = $this->createUserData();
        Session::put('butik.customer', $customer);

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
