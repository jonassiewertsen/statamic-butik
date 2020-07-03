<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Category;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class VariantCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_variant_can_be_created()
    {
        $this->withoutExceptionHandling();

        $variant = raw(Variant::class);
        $this->post(cp_route('butik.variants.store'), $variant)->assertSessionHasNoErrors();
        $this->assertEquals(1, Variant::count());
    }
}
