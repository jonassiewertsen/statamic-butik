<?php

namespace Tests\Shop;

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

    // TODO: Check if item will be displayed correctly as well

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
