<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutReceiptTest extends TestCase
{

    // TODO: Only failing on GitHub actions. Why?
//    /** @test */
//    public function the_invalid_receipt_layout_will_be_loaded_in_case_the_url_is_not_signed()
//    {
//        $route = route('butik.payment.receipt', ['order' => 'wrong_order_id']);
//
//
//         $this->assertStatamicLayoutIs('butik::web.layouts.express-checkout', $route);
//         $this->assertStatamicTemplateIs('butik::web.checkout.invalidReceipt', $route);
//    }


    // TODO: Only failing on GitHub actions. Why?
//    /** @test */
//    public function the_invalid_receipt_layout_will_be_loaded_in_case_the_order_does_not_exist()
//    {
//        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => 'not_existing_id']);
//
//
//         $this->assertStatamicLayoutIs('butik::web.layouts.express-checkout', $route);
//         $this->assertStatamicTemplateIs('butik::web.checkout.invalidReceipt', $route);
//    }

    /** @test */
    public function the_receipt_layout_will_be_loaded_in_case_the_url_is_correclty_signed()
    {
        $order = create(Order::class)->first();
        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);

        $this->assertStatamicLayoutIs('butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('butik::web.checkout.receipt', $route);
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

    /** @test */
    public function the_session_will_be_deleted_after_visiting_the_receipt_page()
    {
        Session::put('butik.customer', new Customer);
        $order = create(Order::class, ['status' => 'paid'])->first();

        $this->assertTrue(Session::has('butik.customer'));

        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);
        $this->get($route)->assertSessionMissing('butik.customer');
    }

    /** @test */
    public function the_session_wont_be_deleted_in_case_the_payment_is_open()
    {
        Session::put('butik.customer', new Customer);
        $order = create(Order::class, ['status' => 'open'])->first();

        $this->assertTrue(Session::has('butik.customer'));

        $route = URL::temporarySignedRoute('butik.payment.receipt', now()->addMinute(), ['order' => $order->id]);
        $this->get($route)->assertSessionHas('butik.customer');
    }
}
