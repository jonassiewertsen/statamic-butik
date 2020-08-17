<?php

namespace Jonassiewertsen\StatamicButik\Tests\Checkout;

use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Mail\Customer\PurchaseConfirmation;
use Jonassiewertsen\StatamicButik\Mail\Seller\OrderConfirmation;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class OrderConfirmationMailTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_sent_to_the_customer()
    {
        $this->withoutExceptionHandling();
        $order = create(Order::class)->first();

        $payment     = new MolliePaymentSuccessful();
        $payment->id = $order->number;

        $this->mockMollie($payment);
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(PurchaseConfirmation::class);
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_addressed_correctly()
    {
        $order = create(Order::class)->first();

        $payment     = new MolliePaymentSuccessful();
        $payment->id = $order->transaction_id;
        $this->mockMollie($payment);
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(PurchaseConfirmation::class, function ($mail) use ($order) {
            return $mail->hasTo(json_decode($order->customer)->mail);
        });
    }

    /** @test */
    public function a_order_confirmation_mail_will_be_sent_to_the_seller()
    {
        $order = create(Order::class)->first();

        $payment     = new MolliePaymentSuccessful();
        $payment->id = $order->transaction_id;

        $this->mockMollie($payment);

        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(OrderConfirmation::class);
    }

    /** @test */
    public function a_order_confirmation_mail_will_be_addressed_to_the_seller()
    {
        $order = create(Order::class)->first();

        $payment     = new MolliePaymentSuccessful();
        $payment->id = $order->transaction_id;

        $this->mockMollie($payment);
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(OrderConfirmation::class, function ($mail) {
            return $mail->hasTo(config('butik.order-confirmations'));
        });
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->orders->get')
            ->andReturn($mock);
    }
}
