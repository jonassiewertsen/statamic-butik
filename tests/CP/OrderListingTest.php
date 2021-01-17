<?php

namespace Jonassiewertsen\StatamicButik\Tests\CP;

use Jonassiewertsen\StatamicButik\Tests\TestCase;

class OrderListingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->signInAdmin();
    }

    /** @test */
    public function a_user_must_be_signed_in_to_call_the_api()
    {
        auth()->logout();

        $this->get(cp_route('butik.api.orders.index'))
            ->assertRedirect(cp_route('login'));
    }

    /** @test */
    public function the_api_route_des_exist()
    {
        $this->get(cp_route('butik.api.orders.index'))->assertOk();
    }
}
