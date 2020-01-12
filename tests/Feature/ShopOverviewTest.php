<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShopOverviewTest extends TestCase
{
    /** @test */
    public function The_shop_overview_page_does_exist()
    {
        $this->withoutExceptionHandling();
        $this->get(route('butik.shop'))->assertOk();
    }
}
