<?php

namespace Jonassiewertsen\StatamicButik\Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CartShippingTest extends TestCase
{
    use MoneyTrait;

    public function setUp(): void {
        parent::setUp();
    }
}
