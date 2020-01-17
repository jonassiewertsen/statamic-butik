<?php

namespace Tests\Checkout;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\CustomerPurchaseConfirmation;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Listeners\CreateOrder;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CreateOrderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $configPath = 'statamic-butik.payment.braintree.';
        $this->app['config']->set($configPath.'env', 'sandbox');
        $this->app['config']->set($configPath.'merchant_id', '8t2hkkd3nn7yqncp');
        $this->app['config']->set($configPath.'public_key', 'j3txsgnhkx8q4cdp');
        $this->app['config']->set($configPath.'private_key', '020f0a4c1d7db142d33e40c04f9a4799');
    }

    /** @test */
    public function a_order_will_be_created(){
        Event::fake([CreateOrder::class]);

        $this->makePayment();

        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function a_order_will_have_the_braintree_order_id(){
        Event::fake([CreateOrder::class]);

        $response = $this->makePayment();
        $id = now()->format('y') .'_'. $response->id;

        $this->assertDatabaseHas('orders', ['id' => $id]);
    }

    /** @test */
    public function a_order_will_contain_the_braintree_amount(){
        Event::fake([CreateOrder::class]);
        $amount = $this->makePayment()->amount;

        $this->assertDatabaseHas('orders', ['total_amount' => $amount]);
    }

    /** @test */
    public function a_order_will_contain_the_braintree_pay_datetime(){
        Event::fake([CreateOrder::class]);
        $createdAt = $this->makePayment()->createdAt->date;
        $createdAt = Carbon::parse($createdAt)->format('Y-m-d H:i:s');

        $this->assertDatabaseHas('orders', ['paid_at' => $createdAt]);
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_sent_to_the_customer(){
        $this->withoutExceptionHandling();
        Event::fake([CreateOrder::class]);
        Mail::fake();

        $amount = $this->makePayment();

        Mail::assertQueued(CustomerPurchaseConfirmation::class);
    }

    private function makePayment()
    {
        $payload = ['payload' => ['nonce' => 'fake-valid-nonce', 'amount' => mt_rand(0.01, 1999.99)]];
        $response = $this->get(route('butik.payment.process', $payload));
        return $response->getData()->transaction;
    }
}
