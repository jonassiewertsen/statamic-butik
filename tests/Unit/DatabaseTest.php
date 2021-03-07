<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Http\Models\Order;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /** @test */
    public function database_test_with_orders()
    {
        $this->assertEquals(0, Order::count());

        create(Order::class);

        $this->assertEquals(1, Order::count());
    }
}
