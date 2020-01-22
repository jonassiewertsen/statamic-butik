<?php

namespace Tests\Checkout;

use Carbon\Carbon;
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
    public function a_purchase_confirmation_mail_will_be_sent_to_the_customer(){
        $order = create(Order::class)->first();

        $payment = new MolliePaymentSuccessful();
        $payment->id = $order->id;

        $this->mockMollie($payment);

        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(PurchaseConfirmation::class);
    }

    /** @test */
    public function a_order_confirmation_mail_will_be_sent_to_the_seller() {
        $order = create(Order::class)->first();

        $payment = new MolliePaymentSuccessful();
        $payment->id = $order->id;

        $this->mockMollie($payment);

        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(OrderConfirmation::class);
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->payments->get')
            ->andReturn($mock);
    }
}
