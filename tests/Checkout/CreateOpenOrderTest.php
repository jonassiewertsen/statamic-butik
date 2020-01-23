<?php

namespace Tests\Checkout;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MollieCustomer;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentOpen;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class CreateOpenOrderTest extends TestCase
{
    protected $cart;

    public function setUp(): void
    {
        parent::setUp();

        $this->cart = (new Cart)
            ->customer($this->createUserData())
            ->addProduct((create(Product::class)->first()));

        Session::put('butik.cart', (new Cart()));

        Mail::fake();
    }

    /** @test */
    public function the_payment_open_event_will_be_fired_when_checking_out() {
        Event::fake();
        $this->checkout();
        Event::assertDispatched(PaymentSubmitted::class);
    }

    /** @test */
    public function an_open_order_will_be_created(){
        $this->checkout();

        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function the_order_id_will_be_identical_with_the_payment_id(){
        $this->checkout();
        $payment = new MolliePaymentSuccessful;

        $this->assertDatabaseHas('butik_orders', ['id' => $payment->id]);
    }

    /** @test */
    public function the_order_will_have_status_open(){
        $this->checkout();

        $this->assertDatabaseHas('butik_orders', ['status' => 'open']);
    }

    /** @test */
    public function the_order_will_have_an_order_type(){
        $this->checkout();
        $payment = new MolliePaymentSuccessful;

        $this->assertDatabaseHas('butik_orders', ['method' => $payment->method ]);
    }

    /** @test */
    public function the_order_will_have_an_total_amount(){
        $this->checkout();
        $payment = new MolliePaymentSuccessful;

        $this->assertDatabaseHas('butik_orders', ['total_amount' => $payment->amount->value ]);
    }

    /** @test */
    public function the_order_will_have_created_at_date(){
        $this->checkout();
        $payment = new MolliePaymentSuccessful;

        $this->assertDatabaseHas('butik_orders', ['created_at' => Carbon::parse($payment->createdAt) ]);
    }

    /** @test */
    public function paid_at_will_stay_null_for_the_moment(){
        $this->checkout();

        $this->assertDatabaseHas('butik_orders', ['paid_at' => null ]);
    }

    /** @test */
    public function the_express_checkout_product_will_be_saved_as_json(){
        $this->checkout();

        $this->assertDatabaseHas('butik_orders', ['products' => json_encode($this->cart->products) ]);
    }

    /** @test */
    public function the_express_checkout_customer_will_be_saved_as_json(){
        $this->checkout();

        $this->assertDatabaseHas('butik_orders', ['customer' => json_encode($this->cart->customer) ]);
    }

    private function checkout() {
        $openPayment = new MolliePaymentOpen();
        Mollie::shouldReceive('api->customers->create')->andReturn(new MollieCustomer());
        Mollie::shouldReceive('api->payments->create')->andReturn($openPayment);
        Mollie::shouldReceive('api->payments->get')->with($openPayment->id)->andReturn($openPayment);

        (new MolliePaymentGateway())->handle($this->cart);
    }

    private function createUserData($key = null, $value = null) {
        $customer = (new Customer)->create([
            'country' => 'Germany',
            'name' => 'John Doe',
            'mail' => 'johndoe@mail.de',
            'address1' => 'Main Street 2',
            'address2' => '',
            'city' => 'Flensburg',
            'state_region' => '',
            'zip' => '24579',
            'phone' => '013643-23837'
       ]);

        if ($key !== null || $value !== null) {
            $customer->$key = $value;
        }

        return $customer;
    }
}
