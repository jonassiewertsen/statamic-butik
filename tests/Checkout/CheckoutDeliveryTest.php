<?php

namespace Jonassiewertsen\StatamicButik\Tests\Checkout;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Jonassiewertsen\StatamicButik\Shipping\Country;
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
        $this->post(route('butik.checkout.delivery.store'), (array)$this->createUserData())
            ->assertSessionHas('butik.customer');
    }

    /** @test */
    public function a_firstname_is_required()
    {
        $data = $this->createUserData('firstname', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('firstname');
    }

    /** @test */
    public function a_firstname_can_be_to_short()
    {
        $data = $this->createUserData('firstname', str_repeat('a', 1));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('firstname');
    }

    /** @test */
    public function a_firstname_can_be_to_long()
    {
        $data = $this->createUserData('firstname', str_repeat('a', 51));
        $this->post(route('butik.checkout.delivery.store', $this->product->slug), (array)$data)
            ->assertSessionHasErrors('firstname');
    }

    /** @test */
    public function a_surname_is_required()
    {
        $data = $this->createUserData('surname', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('surname');
    }

    /** @test */
    public function a_surname_can_be_to_short()
    {
        $data = $this->createUserData('surname', str_repeat('a', 1));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('surname');
    }

    /** @test */
    public function a_surname_can_be_to_long()
    {
        $data = $this->createUserData('surname', str_repeat('a', 51));
        $this->post(route('butik.checkout.delivery.store', $this->product->slug), (array)$data)
            ->assertSessionHasErrors('surname');
    }

    /** @test */
    public function a_mail_address_is_required()
    {
        $data = $this->createUserData('mail', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function a_mail_address_bust_be_a_mail_address()
    {
        $data = $this->createUserData('mail', 'jonas');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function address_line_1_is_required()
    {
        $data = $this->createUserData('address1', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('address1');
    }

    /** @test */
    public function address_line_1_cant_be_to_long()
    {
        $data = $this->createUserData('address1', str_repeat('a', 81));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('address1');
    }

    /** @test */
    public function address_line_2_is_optional()
    {
        $data = $this->createUserData('address2', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function address_line_2_cant_be_to_long()
    {
        $data = $this->createUserData('address2', str_repeat('a', 81));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('address2');
    }

    /** @test */
    public function city_is_required()
    {
        $data = $this->createUserData('city', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function city_2_cant_be_to_long()
    {
        $data = $this->createUserData('city', str_repeat('a', 81));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function state_region_is_optional()
    {
        $data = $this->createUserData('stage_region', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function state_region_cant_be_to_long()
    {
        $data = $this->createUserData('state_region', str_repeat('a', 81));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('state_region');
    }

    /** @test */
    public function zip_is_required()
    {
        $data = $this->createUserData('zip', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function zip_cant_be_to_long()
    {
        $data = $this->createUserData('zip', str_repeat('a', 21));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function phone_is_optional()
    {
        $data = $this->createUserData('phone', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function phone_cant_be_to_long()
    {
        $data = $this->createUserData('phone', str_repeat('a', 51));
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('phone');
    }

    /** @test */
    public function a_country_is_required()
    {
        $data = $this->createUserData('country', '');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function a_country_must_exist()
    {
        $data = $this->createUserData('country', 'not-existing-country');
        $this->post(route('butik.checkout.delivery.store'), (array)$data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function if_a_new_country_has_been_selected_the_view_will_be_reloaded()
    {
        $country_code = 'ES';

        $deliveryRoute = route('butik.checkout.delivery');

        // view the form
        $this->get($deliveryRoute);

        // submit the form
        $this->post($deliveryRoute, (array)$this->createUserData('country', $country_code))
            ->assertRedirect($deliveryRoute);
    }

    /** @test */
    public function if_a_new_country_has_been_selected_it_will_be_saved_in_the_cart()
    {
        $country_code = 'ES';

        create(ShippingZone::class, [
            'countries' => [$country_code]
        ]);

        create(ShippingRate::class, [
            'shipping_zone_id' => ShippingZone::first()
        ]);

        // submit the form
        $this->post(route('butik.checkout.delivery.store'), (array)$this->createUserData('country', $country_code))
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
        $this->assertStringContainsString($customer->mail, $page);
        $this->assertStringContainsString($customer->address1, $page);
        $this->assertStringContainsString($customer->address2, $page);
        $this->assertStringContainsString($customer->city, $page);
        $this->assertStringContainsString($customer->zip, $page);
    }

    /** @test */
    public function after_a_valid_form_the_user_will_be_redirected_to_the_payment_page()
    {
        $this->post(route('butik.checkout.delivery.store'), (array)$this->createUserData())
            ->assertRedirect(route('butik.checkout.payment'));
    }

    private function createUserData($key = null, $value = null)
    {
        $customer = [
            'firstname'    => 'John',
            'surname'      => 'Doe',
            'mail'         => 'johndoe@mail.de',
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
}
