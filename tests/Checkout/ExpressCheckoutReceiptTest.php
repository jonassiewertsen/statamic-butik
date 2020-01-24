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
    public function customer_data_will_be_displayed()
    {
        $this->withoutExceptionHandling();
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
