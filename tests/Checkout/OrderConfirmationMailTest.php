<?php

namespace Tests\Checkout;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\OrderConfirmationForCustomer;
use Jonassiewertsen\StatamicButik\Listeners\CreateOrder;
use Jonassiewertsen\StatamicButik\Mail\OrderConfirmationForSeller;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class OrderConfirmationMailTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $configPath = 'statamic-butik.payment.braintree.';
        $this->app['config']->set($configPath.'env', 'sandbox');
        $this->app['config']->set($configPath.'merchant_id', '8t2hkkd3nn7yqncp');
        $this->app['config']->set($configPath.'public_key', 'j3txsgnhkx8q4cdp');
        $this->app['config']->set($configPath.'private_key', '020f0a4c1d7db142d33e40c04f9a4799');

        Mail::fake();
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_sent_to_the_customer(){
        Event::fake([CreateOrder::class]);
        Mail::fake();

        $amount = $this->makePayment();

        Mail::assertQueued(OrderConfirmationForCustomer::class);
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_contain_transaction_data(){
        $this->withoutExceptionHandling();
        Event::fake([CreateOrder::class]);
        Mail::fake();

        $transaction = $this->makePayment();

        Mail::assertQueued(OrderConfirmationForCustomer::class, function($mail) use ($transaction) {
            return  $mail->transaction['id']                        === $transaction->id &&
                    $mail->transaction['amount']                    === $transaction->amount &&
                    $mail->transaction['currency']                  === $transaction->currencyIsoCode &&
                    Carbon::parse($mail->transaction['created_at'])  == Carbon::parse($transaction->createdAt->date);
        });
    }

    /** @test */
    public function a_purchase_confirmation_mail_will_be_sent_to_the_seller(){
        $this->withoutExceptionHandling();
        Event::fake([CreateOrder::class]);
        Mail::fake();

        $amount = $this->makePayment();

        Mail::assertQueued(OrderConfirmationForSeller::class);
    }

    // TODO: Move up
    private function makePayment()
    {
        $payload = ['payload' => ['nonce' => 'fake-valid-nonce', 'amount' => mt_rand(0.01, 1999.99)]];
        $response = $this->get(route('butik.payment.process', $payload));
        return $response->getData()->transaction;
    }
}
