<?php

namespace Tests\Unit;

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
}
