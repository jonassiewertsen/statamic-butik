<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Exceptions\TransactionSessionDataIncomplete;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutReceiptTest extends TestCase
{
    // TODO: Add a test that the correct redirect url will be past to the mollies redirect

    /** @test */
    public function the_invalid_receipt_layout_will_be_loaded_in_case_the_url_is_not_signed()
    {
        $route = route('butik.payment.receipt', ['id' => 'tr_dasd']);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.invalidReceipt', $route);
    }

    /** @test */
    public function the_receipt_layout_will_be_loaded_in_case_the_url_is_correclty_signed()
    {
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['id' => 'tr_dasd']);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.receipt', $route);
    }

    /** @test */
    public function a_paid_payment_will_show_that_it_is_paid()
    {
        $order = create(Order::class, ['status' => 'paid'])->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->get($route)->assertOk()
            ->assertSee('Payment Successful');
    }

    /** @test */
    public function a_canceled_payment_will_show_that_it_is_canceled()
    {
        $order = create(Order::class, ['status' => 'paid'])->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->get($route)->assertOk()
            ->assertSee('Payment Successful');
    }

    /** @test */
    public function an_open_payment_will_show_that_its_open()
    {
        $order = create(Order::class, ['status' => 'open',])->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id,]);

        $this->get($route)->assertOk()
            ->assertSee('Waiting for payment');
    }

    /** @test */
    public function a_failed_payment_will_show_that_it_did_fail()
    {
        $order = create(Order::class, ['status' => 'failed'])->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->get($route)->assertOk()
            ->assertSee('Your Payment did fail');
    }

    /** @test */
    public function customer_data_will_be_displayed()
    {
        $order = create(Order::class)->first();
        $customer = json_decode($order->customer);
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->get($route)->assertOk()
            ->assertSee($customer->name)
            ->assertSee($customer->mail)
            ->assertSee($customer->address1)
            ->assertSee($customer->zip)
            ->assertSee($customer->city)
            ->assertSee($customer->country);
    }

    /** @test */
    public function payment_data_will_be_displayed()
    {
        $order = create(Order::class)->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->get($route)->assertOk()
            ->assertSee($order->id)
            ->assertSee($order->status)
            ->assertSee($order->method)
            ->assertSee($order->total_amount);
    }
}
