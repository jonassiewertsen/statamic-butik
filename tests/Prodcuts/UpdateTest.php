<?php

namespace Tests\Products;

use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class UpdateTest extends TestCase
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
    public function the_name_can_be_updated()
    {
        $product = create(Product::class)->first();
        $product->title = 'Updated Name';
        $this->updateProduct($product)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('products', ['title' => 'Updated Name']);
    }

    /** @test */
    public function the_description_can_be_updated()
    {
        $product = create(Product::class)->first();
        $product->description = 'Updated Description';
        $this->updateProduct($product);
        $this->assertDatabaseHas('products', ['description' => json_encode('Updated Description')]);
    }
    // TODO: Fix this test
//    /** @test */
//    public function images_can_be_updated()
//    {
//        $product = create(Product::class)->first();
//        $product->images = array('new/image/path.png');
//        $this->updateProduct($product);
//        $this->assertDatabaseHas('products', ['images' =>  'new/image/path.png']);
//    }

    /** @test */
    public function the_base_price_can_be_updated()
    {
        $product = create(Product::class)->first();
        $product->base_price = 4321;
        $this->updateProduct($product);
        $this->assertDatabaseHas('products', [
            'base_price' => 432100 // To zeros added because of the mutation
        ]);
    }

    /** @test */
    public function the_type_can_be_updated()
    {
        $product = create(Product::class)->first();
        $product->type = 'new_type';
        $this->updateProduct($product);
        $this->assertDatabaseHas('products', ['type' => 'new_type' ]);
    }

    private function updateProduct($product) {
        return $this->patch(route('statamic.cp.butik.products.update', $product), $product->toArray());
    }
}
