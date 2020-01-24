<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Exceptions\TransactionSessionDataIncomplete;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ExpressCheckoutReceiptTest extends TestCase
{
    protected $product;
    protected $customer;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = create(Product::class)->first();
        // Setting up a dummy customer
        $this->customer = [
            'country'      => 'Germany',
            'name'         => 'John Doe',
            'mail'         => 'johndoe@mail.de',
            'address_1'    => 'Main Street 2',
            'address_2'    => '',
            'city'         => 'Flensburg',
            'state_region' => '',
            'zip'          => '24579',
            'phone'        => '013643-23837',
        ];
        Session::put('butik.customer', $this->customer);
        // Setting up a dummy transaction
        Session::put(
            'butik.cart', collect(
            [
                'success'         => true,
                'id'              => str_random(8),
                'type'            => 'sale',
                'currencyIsoCode' => 'EUR',
                'amount'          => 1233,
                'created_at'      => now(),
                'customer'        => $this->customer,
            ]));
    }

    /** @test */
    public function the_correct_template_and_layout_will_be_loaded_in_case_the_url_is_invalid()
    {
        $route = route('butik.payment.receipt', ['id' => 'tr_dasd']);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.invalidReceipt', $route);
    }

    /** @test */
    public function the_correct_template_and_layout_will_be_loaded_in_case_the_url_is_invalid()
    {
        $route = route('butik.payment.receipt', ['id' => 'tr_dasd']);

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.invalidReceipt', $route);
    }

    // TODO: Show Redceipt as an signed url

//    /** @test */
//    public function it_can_be_visited_with_successful_transaction()
//    {
//        $this->get($this->product->expressReceiptUrl)->assertOk();
//    }
//
//    /** @test */
//    public function redirect_without_a_successful_transaction_in_the_session_()
//    {
//        Session::put(
//            'butik.transaction', collect(
//            [
//                'success'         => false,
//                'id'              => str_random(8),
//                'type'            => 'sale',
//                'currencyIsoCode' => 'EUR',
//                'amount'          => 1233,
//                'created_at'      => now(),
//            ]));
//        $this->get(create(Product::class)->first()->expressReceiptUrl)->assertRedirect();
//    }
//
//    /** @test */
//    public function redirect_without_a_existing_transaction_in_the_session()
//    {
//        Session::forget('butik.transaction');
//        $this->get(create(Product::class)->first()->expressReceiptUrl)->assertRedirect();
//    }
//
//    /** @test */
//    public function incomplete_transaction_data_will_throw_an_exception()
//    {
//        $this->withoutExceptionHandling();
//        $this->expectException(TransactionSessionDataIncomplete::class);
//        Session::put('butik.transaction', [
//            'success' => true,
//            'created_at' => now(),
//        ]);
//
//        $this->get($this->product->expressReceiptUrl);
//    }
//
//    /** @test */
//    public function middleware_will_delete_transaction_data_after_checkout()
//    {
//        $this->withoutExceptionHandling();
//        Session::put('butik.cart', new Cart());
//
//        $this->get($this->product->expressReceiptUrl)
//            ->assertSessionMissing('butik.cart');
//    }
//
//    /** @test */
//    public function customer_data_will_be_displayed()
//    {
//        $this->get(route('butik.checkout.express.receipt', $this->product))->assertSee(
//                $this->customer['name'])->assertSee($this->customer['mail'])->assertSee(
//                $this->customer['address_1'])->assertSee($this->customer['address_2'])->assertSee(
//                $this->customer['city'])->assertSee($this->customer['zip']);
//    }
//
//    /** @test */
//    public function payment_data_will_be_displayed()
//    {
//        $this->get(route('butik.checkout.express.receipt', $this->product))
//            ->assertSee($this->product->base_price);
//        // ->assertSee($this->customer['order_id']);
//    }
}
