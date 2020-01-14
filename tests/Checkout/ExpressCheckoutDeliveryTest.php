<?php

namespace Tests\Shop;

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
    public function The_express_delivery_page_does_exist()
    {
        dd(config('database'));
        $route = route('butik.checkout.express.delivery', $this->product);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.express.delivery', $route);
    }

    // TODO: Check if item will be displayed correctly as well

    /** @test */
    public function user_data_will_be_saved_inside_the_session() {
        $this->post(route('butik.checkout.express.delivery', $this->product), $this->createUserData())
            ->assertOk()
            ->assertSessionHas('butik.customer');
    }

    /** @test */
    public function a_country_is_required() {
        $data = $this->createUserData('country', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function a_country_cant_be_to_long() {
        $data = $this->createUserData('country', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('country');
    }

    /** @test */
    public function a_name_is_required() {
        $data = $this->createUserData('name', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_cant_be_to_short() {
        $data = $this->createUserData('name', str_repeat('a', 4));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_name_cant_be_to_long() {
        $data = $this->createUserData('name', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_mail_address_is_required() {
        $data = $this->createUserData('mail', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function a_mail_address_bust_be_a_mail_address() {
        $data = $this->createUserData('mail', 'jonas');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('mail');
    }

    /** @test */
    public function address_line_1_is_required() {
        $data = $this->createUserData('address_line_1', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('address_line_1');
    }

    /** @test */
    public function address_line_1_cant_be_to_long() {
        $data = $this->createUserData('address_line_1', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('address_line_1');
    }

    /** @test */
    public function address_line_2_is_optional() {
        $data = $this->createUserData('address_line_2', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function address_line_2_cant_be_to_long() {
        $data = $this->createUserData('address_line_1', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('address_line_1');
    }

    /** @test */
    public function city_is_required() {
        $data = $this->createUserData('city', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function city_2_cant_be_to_long() {
        $data = $this->createUserData('city', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('city');
    }

    /** @test */
    public function state_region_is_optional() {
        $data = $this->createUserData('stage_region', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function state_region_cant_be_to_long() {
        $data = $this->createUserData('state_region', str_repeat('a', 81));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('state_region');
    }

    /** @test */
    public function zip_is_required() {
        $data = $this->createUserData('zip', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function zip_cant_be_to_long() {
        $data = $this->createUserData('zip', str_repeat('a', 21));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('zip');
    }

    /** @test */
    public function phone_is_optional() {
        $data = $this->createUserData('phone', '');
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function phone_cant_be_to_long() {
        $data = $this->createUserData('phone', str_repeat('a', 51));
        $this->post(route('butik.checkout.express.delivery', $this->product), $data)
            ->assertSessionHasErrors('phone');
    }

    private function createUserData($key = null, $value = null) {
        $data = [
            'country' => 'Germany',
            'name' => 'John Doe',
            'mail' => 'johndoe@mail.de',
            'address_line_1' => 'Main Street 2',
            'address_line_2' => '',
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
