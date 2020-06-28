<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class OrderTest extends TestCase
{
    /** @test */
    public function it_has_a_show_link()
    {
        $order = create(Order::class)->first();

        $this->assertEquals(
            $order->showUrl,
            '/'.config('statamic.cp.route')."/butik/orders/{$order->id}"
        );
    }

    /** @test */
    public function the_currency_will_be_converted_correctly()
    {
        $product = create(Order::class, ['total_amount' => 2.13 ]);
        $this->assertEquals('2,13', $product->first()->total_amount);
    }

    /** @test */
    public function the_currency_will_be_saved_without_decimals()
    {
        create(Order::class, ['total_amount' => '2.11' ]);
        $this->assertEquals('211', Order::first()->getRawOriginal('total_amount'));
    }
}
