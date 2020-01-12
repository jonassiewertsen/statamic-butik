<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CpMenuTest extends TestCase
{
    /** @test */
    public function a_login_is_required_to_manage_the_shop()
    {
        $this->get(cp_route('butik.products.index'))
            ->assertRedirect(route('statamic.cp.login'));
    }
}
