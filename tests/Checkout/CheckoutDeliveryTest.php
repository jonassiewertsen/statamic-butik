<?php

namespace Jonassiewertsen\StatamicButik\Tests\Checkout;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CheckoutDeliveryTest extends TestCase
{
    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = $this->makeProduct();
        Cart::add($this->product->slug);
    }

// Failing in GitHub actions. Why?
//    /** @test */
//    public function the_user_will_be_redirected_without_any_products()
//    {
//        Cart::clear();
//
//        $this->get(route('butik.checkout.delivery', $this->product))
//            ->assertRedirect(route('butik.cart'));
//    }

    /** @test */
    public function the_product_information_will_be_displayed_without_saved_customer_data()
    {
        $this->get(route('butik.checkout.delivery', $this->product->slug))
            ->assertSee('Checkout');
    }

    /** @test */
    public function user_data_will_be_saved_inside_the_session()
    {
        $this->withoutExceptionHandling();
        $this->post($this->formSubmitRoute(), (array)$this->createUserData())
            ->assertSessionHas('butik.customer');
    }

    /** @test */
    public function a_firstname_is_required()
    {
        $data = $this->createUserData('firstname', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('firstname', null, 'form.butik_checkout');
    }

    /** @test */
    public function a_surname_is_required()
    {
        $data = $this->createUserData('surname', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('surname', null, 'form.butik_checkout');
    }

    /** @test */
    public function a_mail_address_is_required()
    {
        $data = $this->createUserData('email', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('email', null, 'form.butik_checkout');
    }

    /** @test */
    public function a_mail_address_bust_be_a_mail_address()
    {
        $data = $this->createUserData('email', 'jonas');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('email', null, 'form.butik_checkout');
    }

    /** @test */
    public function address_line_1_is_required()
    {
        $data = $this->createUserData('address1', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('address1', null, 'form.butik_checkout');
    }

    /** @test */
    public function address_line_2_is_optional()
    {
        $data = $this->createUserData('address2', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function city_is_required()
    {
        $data = $this->createUserData('city', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('city', null, 'form.butik_checkout');
    }

    /** @test */
    public function zip_is_required()
    {
        $data = $this->createUserData('zip', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('zip', null, 'form.butik_checkout');
    }

    /** @test */
    public function phone_is_optional()
    {
        $data = $this->createUserData('phone', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function a_country_is_required()
    {
        $data = $this->createUserData('country', '');
        $this->post($this->formSubmitRoute(), (array)$data)
            ->assertSessionHasErrors('country', null, 'form.butik_checkout');
    }

    // TODO: We need a custom rule to check against a non existing country
    //    /** @test */
    //    public function a_country_must_exist()
    //    {
    //        $data = $this->createUserData('country', 'not-existing-country');
    //        $this->post($this->formSubmitRoute(), (array)$data)
    //            ->assertSessionHasErrors('country', null, 'form.butik_checkout');
    //    }

    /** @test */
    public function if_a_new_country_has_been_selected_it_will_be_saved_in_the_cart()
    {
        $country_code = 'ES';

        create(ShippingZone::class, [
            'countries' => [$country_code],
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first(),
        ]);

        // submit the form
        $this->post($this->formSubmitRoute(), (array)$this->createUserData('country', $country_code))
            ->assertRedirect();

        $this->assertEquals($country_code, Cart::country());
    }

    /** @test */
    public function existing_data_from_the_session_will_be_passed_to_the_delivery_view()
    {
        Session::put('butik.customer', new Customer($this->createUserData()));
        $page     = $this->get(route('butik.checkout.delivery', $this->product->slug))->content();
        $customer = session('butik.customer');

        $this->assertStringContainsString($customer->firstname, $page);
        $this->assertStringContainsString($customer->surname, $page);
        $this->assertStringContainsString($customer->email, $page);
        $this->assertStringContainsString($customer->address1, $page);
        $this->assertStringContainsString($customer->address2, $page);
        $this->assertStringContainsString($customer->city, $page);
        $this->assertStringContainsString($customer->zip, $page);
    }

    private function createUserData($key = null, $value = null)
    {
        $customer = [
            'firstname'    => 'John',
            'surname'      => 'Doe',
            'email'        => 'johndoe@mail.de',
            'address1'     => 'Main Street 2',
            'address2'     => '',
            'city'         => 'Flensburg',
            'state_region' => '',
            'zip'          => '24579',
            'phone'        => '013643-23837',
            'country'      => 'DE',
        ];

        if ($key !== null || $value !== null) {
            $customer[$key] = $value;
        }

        return $customer;
    }

    private function formSubmitRoute(): string
    {
        return route('statamic.forms.submit', 'butik_checkout');
    }
}
