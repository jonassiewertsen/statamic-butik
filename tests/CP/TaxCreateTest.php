<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function the_publish_form_will_be_displayed()
    {
        $this->withoutExceptionHandling();
        $this->get(route('statamic.cp.butik.taxes.create'))
            ->assertOK();
    }

    /** @test */
    public function Taxes_can_be_created()
    {
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
    public function slug_is_required()
    {
        $tax = raw(Tax::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First tax
        $product = raw(Tax::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.taxes.store'), $product)
            ->assertSessionHasNoErrors();

        // Another tax with the same slug
        $product = raw(Tax::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.taxes.store'), $product)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function percentage_is_required()
    {
        $tax = raw(Tax::class, ['percentage' => null]);
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

    /** @test */
    public function percentage_must_be_numeric()
    {
        $tax = raw(Tax::class, ['percentage' => 'drei']);
        $this->post(route('statamic.cp.butik.taxes.store'), $tax)
            ->assertSessionHasErrors('percentage');
    }
}
