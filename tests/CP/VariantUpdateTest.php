<?php

namespace Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Variant;
use Tests\TestCase;

class VariantUpdateTest extends TestCase
{
    public Variant $variant;

    public function setUp(): void
    {
        parent::setUp();

        $this->variant = create(Variant::class)->first();

        $this->signInAdmin();
    }

    /** @test */
    public function the_availability_can_be_updated()
    {
        $this->variant->available = false;
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['available' => false]);
    }

    /** @test */
    public function a_title_can_be_updated()
    {
        $this->variant->title = 'new title';
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['title' => 'new title']);
    }

    /** @test */
    public function the_inherit_price_can_be_updated()
    {
        $this->variant->inherit_price = false;
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['inherit_price' => false]);
    }

    /** @test */
    public function the_price_can_be_updated()
    {
        $this->variant->price = '33';
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['price' => 330000]);
    }

    /** @test */
    public function the_inherit_stock_can_be_updated()
    {
        $this->variant->inherit_stock = true;
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['inherit_stock' => true]);
    }

    /** @test */
    public function the_stock_can_be_updated()
    {
        $this->variant->stock = 1;
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['stock' => 1]);
    }

    /** @test */
    public function the_stock_unlimited_can_be_updated()
    {
        $this->variant->stock_unlimited = true;
        $this->updateVariant();

        $this->assertDatabaseHas('butik_variants', ['stock_unlimited' => true]);
    }

    private function updateVariant()
    {
        return $this->patch(cp_route('butik.variants.update', $this->variant), $this->variant->getAttributes());
    }
}
