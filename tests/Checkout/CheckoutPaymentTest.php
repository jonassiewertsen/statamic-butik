<?php

namespace TestsCheckout;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\Butik\Checkout\Cart;
use Jonassiewertsen\Butik\Checkout\Customer;
use Jonassiewertsen\Butik\Http\Models\Product;
use Jonassiewertsen\Butik\Shipping\Country;
use Tests\TestCase;

class CheckoutPaymentTest extends TestCase
{
    protected Customer  $customer;
    protected Product   $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = new Customer($this->createUserData());
        $this->product = $this->makeProduct();

        Cart::add($this->product->slug);
    }

//    Failing in GitHub actions. Why?
//    /** @test */
//    public function the_user_will_be_redirected_without_any_products()
//    {
//        Cart::clear();
//
//        $this->get(route('butik.checkout.payment', $this->product))
//            ->assertRedirect(route('butik.cart'));
//    }

    /** @test */
    public function the_pament_view_will_be_shown()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertOk();
    }

    /** @test */
    public function translations_will_be_displayed_on_the_ship_to_card()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertSee('Pay now')
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Country')
            ->assertSee('Address line 1')
            ->assertSee('City')
            ->assertSee('Zip');
    }

    /** @test */
    public function translations_will_be_displayed_on_product_cards()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertSee('Delivery')
            ->assertSee('Review')
            ->assertSee('Receipt')
            ->assertSee('Shipping')
            ->assertSee('Total');
    }

    // TODO: Tests to remove products from the cart, which are sold out.

    // TODO: Tests to remove products from the cart, which are not available.

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_firstname()
    {
        Session::put('butik.customer', new Customer($this->createUserData('firstname', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_surname()
    {
        $this->withoutExceptionHandling();
        Session::put('butik.customer', new Customer($this->createUserData('surname', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_country()
    {
        Session::put('butik.customer', new Customer($this->createUserData('country', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_address_1()
    {
        Session::put('butik.customer', new Customer($this->createUserData('address1', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_city()
    {
        Session::put('butik.customer', new Customer($this->createUserData('city', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_payment_page_will_redirect_back_without_a_zip()
    {
        Session::put('butik.customer', new Customer($this->createUserData('zip', '')));

        $this->get(route('butik.checkout.payment'))
            ->assertRedirect(route('butik.checkout.delivery'));
    }

    /** @test */
    public function the_product_information_will_be_displayed()
    {
        Session::put('butik.customer', $this->customer);
        Cart::add($this->product->slug);
        Cart::add($this->product->slug);

        $item = Cart::get()->first();

        $this->get(route('butik.checkout.payment'))
            ->assertOk()
            ->assertSee($item->name)
            ->assertSee($item->singlePrice())
            ->assertSee($item->totalPrice())
            ->assertSee($item->getQuantity());
    }

    /** @test */
    public function the_total_information_will_be_displayed()
    {
        Session::put('butik.customer', $this->customer);

        $this->get(route('butik.checkout.payment'))
            ->assertOk()
            ->assertSee(Cart::totalShipping())
            ->assertSee(Cart::totalPrice());
    }

    /** @test */
    public function customer_data_will_be_displayed_inside_the_view()
    {
        Session::put('butik.customer', $this->customer);
        $customer = (array) $this->customer;

        $this->get(route('butik.checkout.payment'))
            ->assertSee($customer['firstname'])
            ->assertSee($customer['surname'])
            ->assertSee($customer['email'])
            ->assertSee($customer['address1'])
            ->assertSee($customer['address2'])
            ->assertSee($customer['city'])
            ->assertSee($customer['zip'])
            ->assertSee(Country::getName($customer['country']));
    }

    private function createUserData($key = null, $value = null): array
    {
        $customer = [
            'country'      => 'DE',
            'firstname'    => 'John',
            'surname'      => 'Doe',
            'email'        => 'johndoe@mail.de',
            'address1'     => 'Main Street 2',
            'address2'     => '',
            'city'         => 'Flensburg',
            'state_region' => '',
            'zip'          => '24579',
            'phone'        => '013643-23837',
        ];

        if ($key !== null || $value !== null) {
            $customer[$key] = $value;
        }

        return $customer;
    }
}
