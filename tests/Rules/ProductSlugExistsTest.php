<?php

namespace Tests\Rules;

use Jonassiewertsen\StatamicButik\Rules\ProductSlugExists;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductSlugExistsTest extends TestCase
{
    /** @test */
    public function will_return_true_if_the_product_slug_exists()
    {
        $rule = new ProductSlugExists();
        $product = $this->makeProduct();

        $this->assertTrue($rule->passes('attribute', $product->slug));
    }

    /** @test */
    public function will_return_false_if_the_product_slug_exists()
    {
        $rule = new ProductSlugExists();

        $this->assertFalse($rule->passes('attribute', 'not-existing'));
    }
}
