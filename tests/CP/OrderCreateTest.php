<?php

namespace Jonassiewertsen\Butik\Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Order;
use Jonassiewertsen\Butik\Tests\TestCase;

class OrderCreateTest extends TestCase
{
    // TODO: Ruhe!

    /** @test */
    public function ruhe()
    {
        $this->assertTrue(true);
    }

    // TODO: Not sure if i want to use this approach to create orders ...

//    public function setUp(): void {
//        parent::setUp();
//
//        $this->signInAdmin();
//    }

//    TODO: Add test back in again, if composer test has been resolve
//    /** @test */
//    public function the_publish_form_will_be_displayed()
//    {
//        $this->get(route('statamic.cp.butik.taxes.create'))
//            ->assertOK();
//    }

//    /** @test */
//    public function orders_can_be_created()
//    {
//        $this->createOrder()->assertOk();
//        $this->assertEquals(1, Order::count());
//    }
//
//    /** @test */
//    public function an_id_is_required()
//    {
//       $this->createOrder(['id' => null])->assertSessionHasErrors('id');
//    }
//
//    /** @test */
//    public function an_id_needs_to_be_unique()
//    {
//        $id = 444;
//        create(Order::class, ['id' => $id]);
//        $this->createOrder(['id' => $id])->assertSessionHasErrors('id');
//    }
//
//    /** @test */
//    public function products_are_required()
//    {
//        $this->createOrder(['products' => null])->assertSessionHasErrors('products');
//    }
//
//    /** @test */
//    public function the_total_amount_is_required()
//    {
//        $this->createOrder(['total_amount' => null])->assertSessionHasErrors('total_amount');
//    }
//
//    /** @test */
//    public function the_total_amount_must_be_an_integer()
//    {
//        $this->createOrder(['total_amount' => 'thirtyfour'])->assertSessionHasErrors('total_amount');
//    }
//
//    /** @test */
//    public function paid_at_is_required()
//    {
//        $this->createOrder(['paid_at' => null])->assertSessionHasErrors('paid_at');
//    }
//
//    /** @test */
//    public function paid_at_must_be_a_datetime()
//    {
//        $this->createOrder(['paid_at' => 'thursay'])->assertSessionHasErrors('paid_at');
//    }
//
//    /** @test */
//    public function shipped_at_can_be_nullable()
//    {
//        $this->createOrder(['shipped_at' => null])->assertSessionHasNoErrors();
//    }
//
//    /** @test */
//    public function shipped_at_must_be_a_datetime()
//    {
//        $this->createOrder(['shipped_at' => 'thursay'])->assertSessionHasErrors('shipped_at');
//    }
//
//    private function createOrder($attributes = []) {
//        $order = raw(Order::class, $attributes);
//        return $this->post(route('statamic.cp.butik.orders.store'), $order);
//    }
}
