<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Tags\Butik;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductPermissionsTest extends TestCase
{
    /** @test */
    public function a_view_permission_is_needed(){
        // TODO: Get tests in place, after the Statamic issue has been resolved
        // that cp views will throw 500 errors.

        // $this->signInUser();
        // $this->get(cp_route('butik.products.index'))->assertUnauthorized();

        // $this->signInUser(['view products']);
        // $this->get(cp_route('butik.products.index'))->assertStatus(500);
    }
}
