<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Event;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentTest extends TestCase
{
    protected $payload;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function a_successful_payment_will_fire_the_an_event()
    {
        $this->mockMollie(new MolliePaymentSuccessful());

        $this->post(route('butik.payment.webhook.mollie'), ['id' => 'tr_fake_id']);
        Event::assertDispatched(PaymentSuccessful::class);
    }

    /** @test */
    public function a_successful_payment_without_payment_id_wont_fire_the_event()
    {
        $this->mockMollie(new MolliePaymentSuccessful());

        $this->post(route('butik.payment.webhook.mollie'));
        Event::assertNotDispatched(PaymentSuccessful::class);
    }

    /** @test */
    public function a_successful_payment_will_update_the_order_status()
    {
        $order = create(Order::class)->first();

        $paymentResponse = new MolliePaymentSuccessful();
        $paymentResponse->id = $order->id;

        $this->mockMollie($paymentResponse);

        $this->assertDatabaseHas('butik_orders', ['id' => $order->id, 'status' => 'open']);

        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);
        $this->assertDatabaseHas('butik_orders', ['id' => $order->id, 'status' => 'paid']);
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->payments->get')
            ->once()
            ->andReturn($mock);
    }
}
