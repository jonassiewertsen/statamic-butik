<?php

namespace Tests\Tags;

use Jonassiewertsen\StatamicButik\Tags\Butik;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ButikTagTest extends TestCase
{
    public $tag;

    public function setUp(): void
    {
        parent::setUp();
        $this->tag = new Butik();
    }

   /** @test */
   public function it_will_return_the_default_shop_route()
   {
       $this->assertEquals(route('butik.shop'), $this->tag->shop(),);
   }

    /** @test */
    public function it_will_return_the_bag_route()
    {
        $this->assertEquals(route('butik.cart'), $this->tag->bag(),);
    }
}
