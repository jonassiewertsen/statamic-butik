<?php

namespace Tests\Unit;

use \Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class TaxTest extends TestCase
{
    /** @test */
    public function taxes_have_a_edit_url()
    {
        $tax = create(Tax::class)->first();

        $this->assertEquals(
            $tax->editUrl(),
            '/'.config('statamic.cp.route')."/butik/taxes/{$tax->id}/edit"
            );
    }
}
