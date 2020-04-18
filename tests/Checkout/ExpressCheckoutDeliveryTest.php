<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutDeliveryTest extends TestCase
{
    protected $product;

    public function setUp(): void {
        parent::setUp();

        $this->product = create(Product::class)->first();
    }

    /** @test */
    public function The_express_delivery_page_does_exist() {
        $customer = new Customer($this->createUserData());
        Session::put('butik.customer', $customer);

        $route = route('butik.checkout.express.delivery', $this->product);

        $this->get($route)
            ->assertOk()
            ->assertViewIs('butik::web.checkout.express-delivery');
    }

    /** @test */
    public function the_product_information_will_be_displayed_without_saved_customer_data() {
        $this->get(route('butik.checkout.express.delivery', $this->product))
            ->assertSee($this->product->title)
            ->assertSee($this->product->base_price)
            ->assertSee($this->product->total_price)
            ->assertSee($this->product->tax_amount)
            ->assertSee($this->product->tax_percentage);
    }

    /** @test */
    public function the_product_information_will_be_displayed() {
        $customer = new Customer($this->createUserData());
        Session::put('butik.customer', $customer);

        $this->get(route('butik.checkout.express.delivery', $this->product))
            ->assertSee($this->product->title)
            ->assertSee($this->product->base_price)
            ->assertSee($this->product->total_price)
            ->assertSee($this->product->tax_amount)
            ->assertSee($this->product->tax_percentage);
    }

    /** @test */
    public function translations_will_be_displayed() {
        $customer = new Customer($this->createUserData());
        Session::put('butik.customer', $customer);

        $this->get(route('butik.checkout.express.delivery', $this->product))
            ->assertSee('Delivery')
            ->assertSee('Review &amp; Payment')
            ->assertSee('Receipt')
            ->assertSee('Express Checkout')
            ->assertSee('Subtotal')
            ->assertSee('Shipping')
            ->assertSee('Total')
            ->assertSee('To payment')
            ->assertSee('Your Information')
            ->assertSee('Delivery Address')
            ->assertSee('We will <span class="butik-underline">not</span> ask you to create an account. Nobody likes doing that ...')
            ->assertSee('Name')
            ->assertSee('Mail')
            ->assertSee('Country')
            ->assertSee('Address 1')
            ->assertSee('Address 2')
            ->assertSee('City')
            ->assertSee('Zip');
    }

    /** @test */
    public function user_data_will_be_saved_inside_the_session() {
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $this->createUserData())
            ->assertSessionHas('butik.customer');
    }

    /** @test */
    public function a_country_is_required() {
        $data = $this->createUserData('country', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function a_country_cant_be_to_long() {
        $data = $this->createUserData('country', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function a_name_is_required() {
        $data = $this->createUserData('name', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_cant_be_to_short() {
        $data = $this->createUserData('name', str_repeat('a', 4));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_cant_be_to_long() {
        $data = $this->createUserData('name', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_mail_address_is_required() {
        $data = $this->createUserData('mail', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function a_mail_address_bust_be_a_mail_address() {
        $data = $this->createUserData('mail', 'jonas');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function address_line_1_is_required() {
        $data = $this->createUserData('address1', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('address1');
    }

    /** @test */
    public function address_line_1_cant_be_to_long() {
        $data = $this->createUserData('address1', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('address1');
    }

    /** @test */
    public function address_line_2_is_optional() {
        $data = $this->createUserData('address2', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function address_line_2_cant_be_to_long() {
        $data = $this->createUserData('address2', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('address2');
    }

    /** @test */
    public function city_is_required() {
        $data = $this->createUserData('city', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function city_2_cant_be_to_long() {
        $data = $this->createUserData('city', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function state_region_is_optional() {
        $data = $this->createUserData('stage_region', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function state_region_cant_be_to_long() {
        $data = $this->createUserData('state_region', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('state_region');
    }

    /** @test */
    public function zip_is_required() {
        $data = $this->createUserData('zip', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function zip_cant_be_to_long() {
        $data = $this->createUserData('zip', str_repeat('a', 21));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function phone_is_optional() {
        $data = $this->createUserData('phone', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function phone_cant_be_to_long() {
        $data = $this->createUserData('phone', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $data)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function after_a_valid_form_the_user_will_be_redirected_to_the_payment_page() {
        $this->post(route('butik.checkout.express.delivery', $this->product), (array) $this->createUserData())
            ->assertRedirect(route('butik.checkout.express.payment', $this->product));
    }

    /** @test */
    public function existing_data_from_the_session_will_be_passed_to_the_delivery_view() {
        Session::put('butik.customer', new Customer($this->createUserData()));
        $page = $this->get(route('butik.checkout.express.delivery', $this->product))->content();
        $customer = session('butik.customer');

        $this->assertStringContainsString($customer->name, $page);
        $this->assertStringContainsString($customer->country, $page);
        $this->assertStringContainsString($customer->mail, $page);
        $this->assertStringContainsString($customer->address1, $page);
        $this->assertStringContainsString($customer->address2, $page);
        $this->assertStringContainsString($customer->city, $page);
        $this->assertStringContainsString($customer->zip, $page);
    }

    /** @test */
    public function existing_data_will_be_displayed_in_the_form() {
        $customer = new Customer($this->createUserData());
        Session::put('butik.customer', $customer);

        $this->get(route('butik.checkout.express.delivery', $this->product))
            ->assertSee($customer->name)
            ->assertSee($customer->mail)
            ->assertSee($customer->address1)
            ->assertSee($customer->address2)
            ->assertSee($customer->city)
            ->assertSee($customer->zip);
    }

    private function createUserData($key = null, $value = null) {
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
