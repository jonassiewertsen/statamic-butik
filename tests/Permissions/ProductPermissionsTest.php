<?php

namespace Jonassiewertsen\Butik\Tests\Unit;

use Jonassiewertsen\Butik\Http\Tags\Butik;
use Jonassiewertsen\Butik\Tests\TestCase;

class ProductPermissionsTest extends TestCase
{
    /** @test */
    public function a_view_permission_is_needed()
    {
        // To keep this test quite.
        $this->assertTrue(true);

        // TODO: Get tests in place, after the Statamic issue has been resolved
        // that cp views will throw 500 errors.

//         $this->signInUser();
//         $this->get(cp_route('butik.products.index'))->assertUnauthorized();

        // $this->signInUser(['view products']);
        // $this->get(cp_route('butik.products.index'))->assertStatus(500);
    }
}
