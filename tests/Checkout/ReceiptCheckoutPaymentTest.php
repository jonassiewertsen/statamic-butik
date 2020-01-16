<?php

namespace Tests\Shop;

use Illuminate\Support\Facades\Session;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ReceiptCheckoutPaymentTest extends TestCase
{
    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = create(Product::class)->first();

        // Setting up a dummy transaction
        Session::put('butik.transaction', collect(
            [
                'success'         => true,
                'id'              => str_random(8),
                'type'            => 'sale',
                'currencyIsoCode' => 'EUR',
                'amount'          => 1233,
                'created_at'      => now(),
            ]));

        // Setting up a dummy customer
        Session::put(
            'butik.customer', [
            'country'      => 'Germany',
            'name'         => 'John Doe',
            'mail'         => 'johndoe@mail.de',
            'address_1'    => 'Main Street 2',
            'address_2'    => '',
            'city'         => 'Flensburg',
            'state_region' => '',
            'zip'          => '24579',
            'phone'        => '013643-23837',
        ]);
    }

    /** @test */
    public function the_correct_template_and_layout_will_be_loaded(){
        $route = $this->product->expressReceiptUrl();

        $this->assertStatamicLayoutIs('statamic-butik::web.layouts.express-checkout', $route);
        $this->assertStatamicTemplateIs('statamic-butik::web.checkout.express.receipt', $route);
    }

    /** @test */
    public function it_can_be_visited_with_successful_transaction(){
        $this->get($this->product->expressReceiptUrl())->assertOk();
    }

    /** @test */
    public function redirect_without_a_successful_transaction_in_the_session_(){
        Session::put('butik.transaction', collect(
            [
                'success'         => false,
                'id'              => str_random(8),
                'type'            => 'sale',
                'currencyIsoCode' => 'EUR',
                'amount'          => 1233,
                'created_at'      => now(),
            ]
        ));

        $this->get(create(Product::class)->first()->expressReceiptUrl())
            ->assertRedirect();
    }

    /** @test */
    public function redirect_without_a_existing_transaction_in_the_session_(){
        Session::forget('butik.transaction');

        $this->get(create(Product::class)->first()->expressReceiptUrl())
            ->assertRedirect();
    }
}
