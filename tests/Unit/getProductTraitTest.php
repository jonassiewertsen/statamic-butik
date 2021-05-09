<?php

namespace Tests\Unit;

use Jonassiewertsen\Butik\Exceptions\ButikProductException;
use Jonassiewertsen\Butik\Support\Traits\getProduct;
use Tests\TestCase;

class getProductTraitTest extends TestCase
{
    use getProduct;

    /** @test */
    public function a_product_can_be_fetched_via_slug()
    {
        $product = $this->makeProduct();

        $this->assertEquals($product, $this->getProduct($product->slug));
    }

    /** @test */
    public function a_product_repository_instance_will_get_returned()
    {
        $product = $this->makeProduct();

        $this->assertEquals($product, $this->getProduct($product));
    }

    /** @test */
    public function a_non_existing_product_will_throw_an_exception()
    {
        $this->expectException(ButikProductException::class);

        $this->getProduct('not-existing-slug');
    }
}
