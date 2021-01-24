<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxUpdateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function the_update_form_will_be_displayed()
    {
        $this->get(route('statamic.cp.butik.taxes.create'))
            ->assertOK();
    }

    /** @test */
    public function the_title_can_be_updated()
    {
        $tax = create(Tax::class)->first();
        $tax->title = 'Updated Name';
        $this->updateTax($tax)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('butik_taxes', ['title' => 'Updated Name']);
    }

    /** @test */
    public function the_percentage_can_be_updated()
    {
        $tax = create(Tax::class)->first();
        $tax->percentage = 99;
        $this->updateTax($tax);
        $this->assertEquals(Tax::first()->percentage, 99);
    }

    private function updateTax($tax)
    {
        return $this->patch(route('statamic.cp.butik.taxes.update', $tax), $tax->toArray());
    }
}
