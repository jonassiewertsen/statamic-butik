<?php

namespace Tests\Checkout;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Listeners\CreateOpenOrder;
use Jonassiewertsen\StatamicButik\Mail\Customer\PurchaseConfirmation;
use Jonassiewertsen\StatamicButik\Mail\OrderConfirmationForSeller;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentCanceled;
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
        $this->withoutExceptionHandling();
        $order = create(Order::class)->first();

        $payment = new MolliePaymentSuccessful();
        $payment->id = $order->id;

        $this->mockMollie($payment);

        $this->post(route('butik.payment.webhook.mollie'), ['id' => $payment->id]);

        Mail::assertQueued(PurchaseConfirmation::class);
    }

    /** @test */
    public function a_purchase_confirmation_for_the_customer_will_contain_transaction_data(){
        $this->withoutExceptionHandling();
        Event::fake([CreateOpenOrder::class]);
        Mail::fake();

        $transaction = $this->makePayment();

        Mail::assertQueued(CustomerReceipt::class, function($mail) use ($transaction) {
            return  $mail->transaction['id']                        === $transaction->id &&
                    $mail->transaction['amount']                    === $transaction->amount &&
                    $mail->transaction['currency']                  === $transaction->currencyIsoCode &&
                    Carbon::parse($mail->transaction['created_at'])  == Carbon::parse($transaction->createdAt->date);
        });
    }

    /** @test */
    public function a_purchase_confirmation_for_the_seller_will_contain_transaction_data(){
        Event::fake([CreateOpenOrder::class]);
        Mail::fake();

        $transaction = $this->makePayment();

        Mail::assertQueued(OrderConfirmationForSeller::class, function($mail) use ($transaction) {
            return  $mail->transaction['id']                        === $transaction->id &&
                    $mail->transaction['amount']                    === $transaction->amount &&
                    $mail->transaction['currency']                  === $transaction->currencyIsoCode &&
                    Carbon::parse($mail->transaction['created_at'])  == Carbon::parse($transaction->createdAt->date);
        });
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_sent_to_the_seller(){
        $this->withoutExceptionHandling();
        Event::fake([CreateOpenOrder::class]);
        Mail::fake();

        $amount = $this->makePayment();

        Mail::assertQueued(OrderConfirmationForSeller::class);
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->payments->get')
            ->andReturn($mock);
    }
}
