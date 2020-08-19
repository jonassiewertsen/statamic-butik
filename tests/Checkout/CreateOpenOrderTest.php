<?php

namespace Jonassiewertsen\StatamicButik\Tests\Checkout;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Item;
use Jonassiewertsen\StatamicButik\Events\OrderCreated;
use Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways\MolliePaymentGateway;
use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Order\ItemCollection;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentOpen;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class CreateOpenOrderTest extends TestCase
{
    use MoneyTrait;

    protected Customer $customer;
    protected string $totalPrice;
    protected ?Collection $items;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = (new Customer($this->createUserData()));
        $this->items    = collect();
        $this->items->push(new Item(factory(Product::class)->create()->slug));
        $this->totalPrice = $this->items->first()->totalPrice();

        Session::put('butik.customer', $this->customer);

        Mail::fake();
    }

    /** @test */
    public function the_payment_open_event_will_be_fired_when_checking_out()
    {
        Event::fake();
        $this->checkout();
        Event::assertDispatched(OrderCreated::class);
    }

    /** @test */
    public function an_open_order_will_be_created()
    {
        $this->checkout();
        $this->assertCount(1, Order::all());
    }

    /** @test */
    public function the_order_transaction_id_will_be_identical_with_the_payment_id()
    {
        $this->checkout();
        $payment = new MolliePaymentSuccessful;
        $this->assertDatabaseHas('butik_orders', ['id' => $payment->id]);
    }

    /** @test */
    public function the_order_will_have_status_open()
    {
        $this->checkout();
        $this->assertDatabaseHas('butik_orders', ['status' => 'created']);
    }

    /** @test */
    public function the_order_will_have_an_order_type()
    {
        $this->checkout();
        $payment = new MolliePaymentOpen();
        $this->assertDatabaseHas('butik_orders', ['method' => $payment->method]);
    }

    /** @test */
    public function the_order_will_have_an_total_amount()
    {
        $this->checkout();
        $totalPrice = $this->makeAmountSaveable($this->totalPrice);
        $this->assertDatabaseHas('butik_orders', ['total_amount' => $totalPrice]);
    }

    /** @test */
    public function the_order_will_have_created_at_date()
    {
        $this->checkout();
        $this->assertDatabaseHas('butik_orders', ['created_at' => now()]);
    }

    /** @test */
    public function paid_at_will_stay_null_for_the_moment()
    {
        $this->checkout();
        $this->assertDatabaseHas('butik_orders', ['paid_at' => null]);
    }

    /** @test */
    public function the_products_will_be_saved_as_json()
    {
        $this->checkout();
        $items = new ItemCollection($this->items);
        $this->assertDatabaseHas('butik_orders', ['items' => json_encode($items)]);
    }

    /** @test */
    public function the_express_checkout_customer_will_be_saved_as_json()
    {
        $this->checkout();
        $this->assertDatabaseHas('butik_orders', ['customer' => json_encode($this->customer)]);
    }

    private function checkout()
    {
        $openPayment = new MolliePaymentOpen();
        Mollie::shouldReceive('api->orders->create')->andReturn($openPayment);
        Mollie::shouldReceive('api->orders->get')->with($openPayment->id)->andReturn($openPayment);

        (new MolliePaymentGateway())->handle($this->customer, $this->items, $this->totalPrice, Cart::shipping());
    }

    private function createUserData($key = null, $value = null)
    {
        $customer = [
            'country'      => 'Germany',
            'firstname'    => 'John',
            'surname'      => 'Doe',
            'mail'         => 'johndoe@mail.de',
            'address1'     => 'Main Street 2',
            'address2'     => '',
            'city'         => 'Flensburg',
            'state_region' => '',
            'zip'          => '24579',
            'phone'        => '013643-23837',
        ];

        if ($key !== null || $value !== null) {
            $customer->$key = $value;
        }

        return $customer;
    }
}
