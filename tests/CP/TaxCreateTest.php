<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signIn();
    }


//    TODO: Add test back in again, if composer test has been resolve
//    Change to TAX View of course.
//    /** @test */
//    public function the_publish_form_will_be_displayed()
//    {
//        $this->withoutExceptionHandling();
//
//        $this->get(route('statamic.cp.butik.product.create'))
//            ->assertOK();
//    }

    /** @test */
    public function Taxes_can_be_created()
    {
        $this->withoutExceptionHandling();
        $tax = raw(Tax::class);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)->assertSessionHasNoErrors();
        $this->assertEquals(1, Tax::count());
    }

    /** @test */
    public function title_is_required()
    {
        $tax = raw(Tax::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function percentage_is_required()
    {
        $tax = raw(Tax::class, ['percentage' => null]);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('percentage');
    }

    /** @test */
    public function percentage_must_be_an_integer()
    {
        $tax = raw(Tax::class, ['percentage' => 'drei']);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('percentage');
    }

    /** @test */
    public function percentage_cant_be_less_then_zero()
    {
        $tax = raw(Tax::class, ['percentage' => -1 ]);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('percentage');
    }

    /** @test */
    public function percentage_cant_be_higher_then_100()
    {
        $tax = raw(Tax::class, ['percentage' => 101 ]);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('percentage');
    }
}
