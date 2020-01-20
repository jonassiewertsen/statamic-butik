<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

//    TODO: Add test back in again, if composer test has been resolve
//    /** @test */
//    public function the_publish_form_will_be_displayed()
//    {
//        $this->get(route('statamic.cp.butik.shippings.create'))
//            ->assertOK();
//    }

    /** @test */
    public function shippings_can_be_created()
    {
        $this->withoutExceptionHandling();
        $shipping = raw(Shipping::class);
        $this->post(route('statamic.cp.butik.shippings.store'), $shipping)->assertSessionHasNoErrors();
        $this->assertEquals(1, Shipping::count());
    }

    /** @test */
    public function title_is_required()
    {
        $shipping = raw(Shipping::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shippings.store'), $shipping)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function price_is_required()
    {
        $shipping = raw(Shipping::class, ['price' => null]);
        $this->post(route('statamic.cp.butik.shippings.store'), $shipping)
            ->assertSessionHasErrors('price');
    }

//    /** @test */
//    public function price_must_be_an_integer()
//    {
//        $shipping = raw(Shipping::class, ['price' => 'drei']);
//        $this->post(route('statamic.cp.butik.shippings.store'), $shipping)
//            ->assertSessionHasErrors('price');
//    }
}
