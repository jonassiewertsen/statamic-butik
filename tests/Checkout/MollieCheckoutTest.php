<?php

namespace Tests\Shop;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class MollieCheckoutTest extends TestCase
{
    protected $payload;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->app['config']->set('statamic-butik.payment.mollie.key', '020f0a4c1d7db142d33e40c04f9a4799');

//        // Setting up a dummy customer
//        $this->customer = [
//            'country'      => 'Germany',
//            'name'         => 'John Doe',
//            'mail'         => 'johndoe@mail.de',
//            'address_1'    => 'Main Street 2',
//            'address_2'    => '',
//            'city'         => 'Flensburg',
//            'state_region' => '',
//            'zip'          => '24579',
//            'phone'        => '013643-23837',
//        ];
//        Session::put('butik.customer', $this->customer);
    }

    /** @test */
    public function a_payment_can_be_accepted()
    {
        $this->makePayment($this->accepted())->assertJsonFragment(['success' => true]);
    }

//    /** @test */
//    public function a_succesful_will_fire_an_event()
//    {
//        $transaction = $this->makePayment($this->accepted());
//
//        Event::assertDispatched(PaymentSuccessful::class);
//    }
//
//    /** @test */
//    public function a_successful_payment_will_be_saved_in_the_session()
//    {
//        $amount = $this->accepted();
//        $response = $this->makePayment($amount)->getData();
//        $session = Session::get('butik.transaction');
//
//        $this->assertEquals($session['success'], $response->success);
//        $this->assertEquals($session['id'], $response->transaction->id);
//        $this->assertEquals($session['currencyIsoCode'], $response->transaction->currencyIsoCode);
//        $this->assertEquals($session['amount'], $response->transaction->amount);
//        $this->assertEquals($session['created_at'], Carbon::parse($response->transaction->createdAt->date));
//    }
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

    private function accepted()
    {
        return mt_rand(0.01, 1999.99);
    }

    private function declined()
    {
        return mt_rand(2000.00, 2999.99);
    }

    private function failed()
    {
        return mt_rand(3000.00, 3000.99);
    }

    private function gateway()
    {
        return 5001;
    }
}
