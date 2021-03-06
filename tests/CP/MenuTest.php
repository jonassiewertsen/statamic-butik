<?php

namespace Jonassiewertsen\Butik\Tests\CP;

use Jonassiewertsen\Butik\Tests\TestCase;

class MenuTest extends TestCase
{
    /** @test */
    public function a_login_is_required_to_manage_the_shop()
    {
        $this->get(cp_route('butik.orders.index'))
            ->assertRedirect(route('statamic.cp.login'));
    }
}
