<?php

namespace Jonassiewertsen\Butik\Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Variant;
use Jonassiewertsen\Butik\Tests\TestCase;

class VariantCreateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_variant_can_be_created()
    {
        $this->createVariant()->assertSessionHasNoErrors();
        $this->assertEquals(1, Variant::count());
    }

    /** @test */
    public function a_product_slug_is_required()
    {
        $this->createVariant(['product_slug' => ''])
            ->assertSessionHasErrors('product_slug');
    }

    // This validation is not possible at the moment.
    // https://github.com/statamic/cms/issues/2028
    //    /** @test */
    //    public function a_product_slug_must_exist()
    //    {
    //        $this->createVariant(['product_slug' => 'not-existing-slug'])
    //            ->assertSessionHasErrors('product_slug');
    //    }

    /** @test */
    public function a_title_is_required()
    {
        $this->createVariant(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_price_can_be_empty_or_null()
    {
        $this->createVariant(['price' => ''])
            ->assertSessionHasNoErrors();

        $this->createVariant(['price' => null])
            ->assertSessionHasNoErrors();
    }

    // TODO: Not possible at the moment. See Jonassiewertsen\Butik\Http\Controllers\CP\VariantsController
//    /** @test */
//    public function a_price_is_required_if_not_inherited()
//    {
//        $this->createVariant([
//            'inherit_price' => false,
//            'price' => null,
//        ])->assertSessionHasErrors('price');
//    }

    /** @test */
    public function a_stock_can_be_empty_or_null()
    {
        $this->createVariant(['stock' => ''])
            ->assertSessionHasNoErrors();

        $this->createVariant(['stock' => null])
            ->assertSessionHasNoErrors();
    }

    // TODO: Add the test that the stock can't be empty if inherit_stock is set to false

    private function createVariant($data = [])
    {
        $variant = raw(Variant::class, $data);

        return $this->post(cp_route('butik.variants.store'), $variant);
    }
}
