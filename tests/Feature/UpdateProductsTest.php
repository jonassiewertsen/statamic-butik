<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signIn();
    }


//    TODO: Add test back in again, if composer test has been resolved
//    /** @test */
//    public function the_update_form_will_be_displayed()
//    {
//        $this->withoutExceptionHandling();
//
//        $this->get(route('statamic.cp.butik.product.create'))
//            ->assertOK();
//    }

    /** @test */
    public function A_product_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $product = raw(Product::class);
        $this->post(route('statamic.cp.butik.products.store'), $product);
        $this->assertEquals(1, Product::count());
    }
}
