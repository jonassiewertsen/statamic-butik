<?php

namespace Tests\Checkout;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;
use Jonassiewertsen\StatamicButik\Http\Controllers\Web\PaymentGatewayController;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MollieCustomer;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentOpen;
use Mollie\Laravel\Facades\Mollie;

class CreateOrderTest extends TestCase
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

//    /** @test */
//    public function a_order_will_have_the_braintree_order_id(){
//        Event::fake([CreateOrder::class]);
//
//        $response = $this->makePayment();
//        $id = now()->format('y') .'_'. $response->id;
//
//        $this->assertDatabaseHas('orders', ['id' => $id]);
//    }
//
//    /** @test */
//    public function a_order_will_contain_the_braintree_amount(){
//        Event::fake([CreateOrder::class]);
//        $amount = $this->makePayment()->amount;
//
//        $this->assertDatabaseHas('orders', ['total_amount' => $amount]);
//    }
//
//    /** @test */
//    public function a_order_will_contain_the_braintree_pay_datetime(){
//        Event::fake([CreateOrder::class]);
//        $createdAt = $this->makePayment()->createdAt->date;
//        $createdAt = Carbon::parse($createdAt)->format('Y-m-d H:i:s');
//
//        $this->assertDatabaseHas('orders', ['paid_at' => $createdAt]);
//    }
//
//    private function makePayment()
//    {
//        $payload = ['payload' => ['nonce' => 'fake-valid-nonce', 'amount' => mt_rand(0.01, 1999.99)]];
//        $response = $this->get(route('butik.payment.process', $payload));
//        return $response->getData()->transaction;
//    }

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
