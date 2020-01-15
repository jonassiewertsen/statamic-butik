<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Tags\Braintree;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class BraintreeTagTest extends TestCase
{
    public $tag;

    public function setUp(): void {
        parent::setUp();

        $this->tag = new Braintree();
    }

    /** @test */
    public function it_will_return_the_payment_process()
    {
        $this->tag->setParameters([
            'name' => 'payment.process'
        ]);

        $this->assertEquals(route('butik.payment.process'), $this->tag->route());
    }

    /** @test */
    public function a_undefined_route_wont_throw_any_error()
    {
        $this->withoutExceptionHandling();
        $this->tag->setParameters(['name' => 'doesnt exist',]);

        $this->assertEquals(null, $this->tag->route());
    }
}
