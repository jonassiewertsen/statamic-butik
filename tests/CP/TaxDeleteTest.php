<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxDeleteTest extends TestCase
{
    /** @test */
    public function taxes_can_be_deleted()
    {
        $this->signIn();

        $tax = create(Tax::class);
        $this->assertEquals(1, $tax->count());

        $this->delete(route('statamic.cp.butik.taxes.destroy', $tax->first()))
            ->assertOk();

        $this->assertEquals(0, Tax::count());
    }
}
