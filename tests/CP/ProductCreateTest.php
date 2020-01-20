<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ProductCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }


//    TODO: Add test back in again, if composer test has been resolved
//    /** @test */
//    public function the_publish_form_will_be_displayed()
//    {
//        $this->withoutExceptionHandling();
//
//        $this->get(route('statamic.cp.butik.product.create'))
//            ->assertOK();
//    }

    /** @test */
    public function A_product_can_be_created()
    {
        $this->withoutExceptionHandling();
        $product = raw(Product::class);
        $this->post(route('statamic.cp.butik.products.store'), $product)->assertSessionHasNoErrors();
        $this->assertEquals(1, Product::count());
    }

    /** @test */
    public function available_is_required()
    {
        $product = raw(Product::class, ['available' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('available');
    }

    /** @test */
    public function available_must_be_a_boolean()
    {
        $product = raw(Product::class, ['available' => 'yes']);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('available');
    }

    /** @test */
    public function title_is_required()
    {
        $product = raw(Product::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function title_must_be_a_string()
    {
        $product = raw(Product::class, ['title' => 123 ]);
        $response = $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function slug_is_required()
    {
        $product = raw(Product::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_a_string()
    {
        $product = raw(Product::class, ['slug' => 123 ]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('slug');
    }
    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First Product
        $product = raw(Product::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasNoErrors();

        // Another product with the same slug
//        $product = raw(Product::class, ['slug' => $slug ]);
//        $this->post(route('statamic.cp.butik.products.store'), $product)
//            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function description_can_be_empty()
    {
        $product = raw(Product::class, ['description' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function images_can_be_null()
    {
        $product = raw(Product::class, ['images' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionhasNoErrors();
    }

    /** @test */
    public function tax_is_required()
    {
        $product = raw(Product::class, ['tax_id' => '']);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('tax_id');
    }

    /** @test */
    public function taxes_relation_must_exist_required()
    {
        $product = raw(Product::class, ['tax_id' => 44]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('tax_id');
    }

    /** @test */
    public function shipping_is_required()
    {
        $product = raw(Product::class, ['shipping_id' => '']);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('shipping_id');
    }

    /** @test */
    public function shipping_relation_must_exist_required()
    {
        $product = raw(Product::class, ['shipping_id' => 44]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('shipping_id');
    }

    /** @test */
    public function base_price_is_required()
    {
        $product = raw(Product::class, ['base_price' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('base_price');
    }

    /** @test */
    public function stock_is_required()
    {
        $product = raw(Product::class, ['stock' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('stock');
    }

    /** @test */
    public function stock_must_be_an_integer()
    {
        $product = raw(Product::class, ['stock' => 'five']);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('stock');
    }

    /** @test */
    public function stock_unlimited_is_required()
    {
        $product = raw(Product::class, ['stock_unlimited' => null]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('stock_unlimited');
    }

    /** @test */
    public function stock_unlimited_must_be_a_boolean()
    {
        $product = raw(Product::class, ['stock_unlimited' => 'yes']);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('stock_unlimited');
    }

// TODO: Important to test?
//    /** @test */
//    public function base_price_cant_be_lower_then_zero()
//    {
//        $product = raw(Product::class, ['base_price' => -3 ]);
//        $this->post(route('statamic.cp.butik.products.store'), $product)
//            ->assertSessionHasErrors('base_price');
//    }

    /** @test */
    public function product_type_is_required()
    {
        $product = raw(Product::class, ['type' => null ]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('type');
    }

    /** @test */
    public function product_type_is_a_string()
    {
        $product = raw(Product::class, ['type' => 12 ]);
        $this->post(route('statamic.cp.butik.products.store'), $product)
            ->assertSessionHasErrors('type');
    }
}
