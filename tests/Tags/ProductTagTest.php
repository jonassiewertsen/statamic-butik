<?php

namespace Tests\Tags;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductTagTest extends TestCase
{
    public $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    /** @test */
    public function quiet_please()
    {
        $this->assertTrue(true);
    }
}
