<?php

namespace Tests\Checkout;

use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;
use Jonassiewertsen\StatamicButik\Tests\Utilities\MolliePaymentSuccessful;
use Mollie\Laravel\Facades\Mollie;

class ProductStockTest extends TestCase
{
    protected $cart;

    public function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /** @test */
    public function the_prodcut_stock_will_be_reduced_by_one_after_checkout() {
        $order = create(Order::class, ['transaction_id' => 'tr_fake_id'])->first();
        $stock = Product::first()->stock;

        $this->assertEquals($stock, Product::first()->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);
//
        $this->assertEquals($stock - 1, Product::first()->stock);
    }

    /** @test */
    public function the_prodcut_stock_wont_be_reduced_on_unlimited_products() {
        $order = create(Order::class, ['transaction_id' => 'tr_fake_id'])->first();

        $product = Product::first();
        $product->stock_unlimited = true;
        $product->save();

        $stock = Product::first()->stock;

        $this->assertEquals($stock, Product::first()->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $this->assertEquals($stock, Product::first()->stock);
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->payments->get')
            ->andReturn($mock);
    }
}
