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
    public function The_express_payment_page_does_exist()
    {
        $route = route('butik.checkout.express.payment', $this->product);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.express.payment', $route);
    }

    /** @test */
    public function the_product_information_will_be_displayed(){
        $this->get(route('butik.checkout.express.payment', $this->product))
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
