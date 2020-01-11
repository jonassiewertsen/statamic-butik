<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CpMenuTest extends TestCase
{
    /** @test */
    public function a_login_is_required()
    {
        $this->get(cp_route('butik.product.index'))
            ->assertRedirect(route('statamic.cp.login'));
    }

    /** @test */
    public function a_user_can_be_logged_in()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get(cp_route('dashboard'))->assertOk();
    }
}
