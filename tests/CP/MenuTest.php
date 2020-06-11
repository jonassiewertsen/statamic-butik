<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class MenuTest extends TestCase
{
    /** @test */
    public function a_login_is_required_to_manage_the_shop()
    {
        $this->get(cp_route('butik.products.index'))
            ->assertRedirect(route('statamic.cp.login'));
    }
}
