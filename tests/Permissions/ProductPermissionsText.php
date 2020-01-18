<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Tags\Butik;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductPermissionsText extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->user = $this->signInAdmin();
    }

    /** @test */
    public function ex_test(){
        //
    }
}
