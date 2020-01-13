<?php

namespace Tests\Shop;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class BraintreeCheckoutTest extends TestCase
{
    protected $payload;

    public function setUp(): void {
        parent::setUp();

        $configPath = 'statamic-butik.payment.braintree.';
        $this->app['config']->set($configPath.'env', 'sandbox');
        $this->app['config']->set($configPath.'merchant_id', '8t2hkkd3nn7yqncp');
        $this->app['config']->set($configPath.'public_key', 'j3txsgnhkx8q4cdp');
        $this->app['config']->set($configPath.'private_key', '020f0a4c1d7db142d33e40c04f9a4799');
    }

    /** @test */
    public function a_payment_can_be_accepted() {
        $this->makePayment($this->accepted())
            ->assertJsonFragment(['success' => true]);
    }

    /** @test */
    public function a_payment_can_be_declined() {
        $this->makePayment($this->declined())
            ->assertJsonFragment(['message' => 'Processor Declined']);
    }

    /** @test */
    public function a_payment_can_fail() {
        $this->makePayment($this->failed())
            ->assertJsonFragment(['message' => 'Processor Network Unavailable - Try Again']);
    }

    /** @test */
    public function a_payment_can_fail_because_of_the_gateway() {
        $this->makePayment($this->gateway())
            ->assertJsonFragment(['message' => 'Gateway Rejected: application_incomplete']);
    }

    private function makePayment($amount, $nonce = 'fake-valid-nonce') {
        $payload = ['payload' => ['nonce' => $nonce, 'amount' => $amount ]];
        return $this->get(route('butik.payment.handle', $payload));
    }

    private function accepted() {
        return mt_rand(0.01, 1999.99);
    }

    private function declined() {
        return mt_rand(2000.00, 2999.99);
    }

    private function failed() {
        return mt_rand(3000.00, 3000.99);
    }

    private function gateway() {
        return 5001;
    }
}
