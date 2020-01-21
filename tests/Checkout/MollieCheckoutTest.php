<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Event;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class MollieCheckoutTest extends TestCase
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
        $this->withoutExceptionHandling();
        Mollie::shouldReceive('api->payments->get')
                ->once()
                ->andReturn(new MolliePaymentSuccessful());

        $this->post(route('butik.payment.webhook.mollie'), ['id' => 'some_fake_id']);
        Event::assertDispatched(PaymentSuccessful::class);
    }


//
//    /** @test */
//    public function customer_informations_will_be_transfered_into_the_payment_session(){
//        $amount = $this->accepted();
//        $response = $this->makePayment($amount);
//
//        $response->assertSessionMissing('butik.customer')
//            ->assertSessionHas('butik.transaction.customer', $this->customer);
//    }
//
//    /** @test */
//    public function a_payment_can_be_declined()
//    {
//        $this->makePayment($this->declined())->assertJsonFragment(['message' => 'Processor Declined']);
//        // TODO: This does not work like this. The Response is json ... so vue needs to handle this.
//        // What about a popup with all the information? That would be cool. From there the user can go to another site or whatever ...
//    }
//
//    /** @test */
//    public function a_payment_can_fail()
//    {
//        $this->makePayment($this->failed())->assertJsonFragment(['message' => 'Processor Network Unavailable - Try Again']);
//    }
//
//    /** @test */
//    public function a_payment_can_fail_because_of_the_gateway()
//    {
//        $this->makePayment($this->gateway())->assertJsonFragment(['message' => 'Gateway Rejected: application_incomplete']);
//    }
//
//    private function makePayment($amount, $nonce = 'fake-valid-nonce')
//    {
//        $payload = ['payload' => ['nonce' => $nonce, 'amount' => $amount]];
//        return $this->get(route('butik.payment.process', $payload));
//    }

//    private function accepted()
//    {
//        return mt_rand(0.01, 1999.99);
//    }
//
//    private function declined()
//    {
//        return mt_rand(2000.00, 2999.99);
//    }
//
//    private function failed()
//    {
//        return mt_rand(3000.00, 3000.99);
//    }
//
//    private function gateway()
//    {
//        return 5001;
//    }
}
