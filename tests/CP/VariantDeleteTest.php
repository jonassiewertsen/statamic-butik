<?php

namespace Tests\CP;

use Jonassiewertsen\Butik\Http\Models\Variant;
use Tests\TestCase;
use Statamic\Events\EntryDeleted;
use Statamic\Facades\Entry;

class VariantDeleteTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signInAdmin();
    }

    /** @test */
    public function a_variant_can_be_deleted()
    {
        $variant = create(Variant::class)->first();
        $this->assertCount(1, Variant::all());

        $this->delete(cp_route('butik.variants.destroy', $variant));

        $this->assertCount(0, Variant::all());
    }

    /** @test */
    public function a_variant_will_be_deleted_if_the_parent_product_gets_deleted()
    {
        $product = $this->makeProduct();

        create(Variant::class, ['product_slug' => $product->slug]);
        $this->assertCount(1, Variant::all());

        $entry = Entry::findBySlug($product->slug, 'products');
        EntryDeleted::dispatch($entry);

        $this->assertCount(0, Variant::all());
    }
}
