<?php

namespace Tests\Unit;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class CreatingProductsTest extends TestCase
{
    /** @test */
    public function the_publish_form_can_be_accessed()
    {
        $this->withoutExceptionHandling();

        $this->get(route('statamic.cp.butik.product.create'))
            ->assertOK();
    }

    // test -> cant access route without login

    /** @test */
    public function a_product_will_be_stored_in_the_database()
    {
        $product = raw(Product::class);

        $this->post(route('statamic.cp.butik.product.store'), $product);

        $this->assertDatabaseHas('products', $product);
    }
}
