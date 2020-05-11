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

    /** @test */
    public function the_publish_form_will_be_displayed()
    {
        $this->get(route('statamic.cp.butik.shippings.create'))
            ->assertOK();
    }

    /** @test */
    public function shippings_can_be_created()
    {
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
    public function slug_is_required()
    {
        $shipping = raw(Shipping::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.shippings.store'), $shipping)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First shipping
        $product = raw(Shipping::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shippings.store'), $product)
            ->assertSessionHasNoErrors();

        // Another shipping with the same slug
        $product = raw(Shipping::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shippings.store'), $product)
            ->assertSessionHasErrors('slug');
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
