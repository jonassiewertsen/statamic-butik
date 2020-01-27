<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use \Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxTest extends TestCase
{
    protected $tax;

    public function setUp(): void
    {
        parent::setUp();
        $this->tax = create(Tax::class)->first();
    }

    /** @test */
    public function a_tax_has_products(){
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->tax->products);
    }

    /** @test */
    public function taxes_have_a_edit_url()
    {
        $this->assertStringContainsString(
            $this->tax->editUrl(),
            cp_route('butik.taxes.edit', $this->tax)
        );
    }
}
