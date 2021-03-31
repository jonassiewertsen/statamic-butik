<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Exceptions\ButikProductException;
use Jonassiewertsen\Butik\Facades\Tax;
use Tests\TestCase;

class TaxTest extends TestCase
{
    public $tax;

    public function setUp(): void
    {
        parent::setUp();
        $this->tax = $this->makeTax();
    }

    /** @test */
    public function it_can_fetch_all_taxes()
    {
        $taxes = Tax::all();

        $this->assertCount(1, $taxes);
    }

    /** @test */
    public function a_product_can_be_found()
    {
        $this->assertEquals($this->tax, Tax::find($this->tax->id));
    }

    /** @test */
    public function a_tax_can_be_found_by_its_slug()
    {
        $this->assertEquals($this->tax, Tax::findBySlug($this->tax->slug));
    }

    /** @test */
    public function a_tax_title_can_be_updated()
    {
        $this->tax->update(['title' => 'new title']);

        $this->assertEquals('new title', $this->tax->fresh()->title);
    }

    /** @test */
    public function a_tax_rate_can_be_updated()
    {
        $this->tax->update(['rate' => '33']);

        $this->assertEquals('33', $this->tax->fresh()->rate);
    }

    /** @test */
    public function a_tax_can_be_deleted()
    {
        $this->assertCount(1, Tax::all());

        $tax = Tax::all()->first();
        $tax->delete();

        $this->assertCount(0, Tax::all());
    }

    /** @test */
    public function a_not_found_tax_cant_be_deleted_and_will_throw_an_exception()
    {
        $this->expectException(ButikProductException::class); // TODO: should we throw a different exception?

        Tax::delete('not existing');
    }
}
