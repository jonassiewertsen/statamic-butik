<?php

namespace Tests\CP;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingType;
use Jonassiewertsen\StatamicButik\Tests\TestCase;

class ShippingTypeCreateTestCreateTest extends TestCase
{
    public function setUp(): void {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function countries_can_be_created()
    {
        $country = raw(ShippingType::class);
        $this->post(route('statamic.cp.butik.shipping-types.store'), $country)->assertSessionHasNoErrors();
        $this->assertEquals(1, ShippingType::count());
    }

    /** @test */
    public function title_is_required()
    {
        $shippingType = raw(ShippingType::class, ['title' => null]);
        $this->post(route('statamic.cp.butik.shipping-types.store'), $shippingType)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function slug_is_required()
    {
        $shippingType = raw(ShippingType::class, ['slug' => null]);
        $this->post(route('statamic.cp.butik.shipping-types.store'), $shippingType)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $slug = 'not-unique';

        // First country
        $country = raw(ShippingType::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-types.store'), $country)
            ->assertSessionHasNoErrors();

        // Another country with the same slug
        $country = raw(ShippingType::class, ['slug' => $slug ]);
        $this->post(route('statamic.cp.butik.shipping-types.store'), $country)
            ->assertSessionHasErrors('slug');
    }
}
