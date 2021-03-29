<?php

namespace Tests\Checkout;

use Facades\Jonassiewertsen\Butik\Http\Models\Product;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\Butik\Cart\Item;
use Jonassiewertsen\Butik\Http\Models\Order;
use Jonassiewertsen\Butik\Http\Models\Variant;
use Jonassiewertsen\Butik\Item\ItemCollection;
use Mollie\Laravel\Facades\Mollie;
use Statamic\Facades\Entry;
use Tests\TestCase;
use TestsUtilities\MolliePaymentSuccessful;

class ProductStockTest extends TestCase
{
    protected $cart;

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /** @test */
    public function the_prodcut_stock_will_be_reduced_by_one_for_a_single_product_after_checkout()
    {
        $order = create(Order::class, ['id' => 'tr_fake_id'])->first();
        $product = Product::find($order->items[0]->slug);
        $stock = $product->stock;

        $this->assertEquals($stock, $product->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $product = Product::find($product->slug);
        $this->assertEquals($stock - 1, $product->stock);
    }

    /** @test */
    public function the_prodcut_stock_will_be_reduced_by_the_items_quantity_after_checkout()
    {
        $product = $this->makeProduct();
        $stock = $product->stock;

        $item = (new Item($product->slug));
        $item->setQuantity(2);

        $collection = new ItemCollection(collect()->push($item));

        $order = create(Order::class, [
            'id'    => 'tr_fake_id',
            'items' => $collection->items,
        ])->first();

        $this->assertEquals($stock, $product->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $this->assertEquals($stock - 2, Product::find($product->slug)->stock);
    }

    /** @test */
    public function the_variant_stock_will_be_reduced_by_the_items_quantity_after_checkout()
    {
        $product = $this->makeProduct();
        $variant = create(Variant::class, ['inherit_stock' => false, 'product_slug' => $product->slug])->first();
        $stock = $variant->stock;

        $item = (new Item($variant->slug));
        $item->setQuantity(2);

        $collection = new ItemCollection(collect()->push($item));

        $order = create(Order::class, [
            'id'    => 'tr_fake_id',
            'items' => $collection->items,
        ])->first();

        $this->assertEquals($stock, Variant::first()->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $this->assertEquals($stock - 2, $variant->fresh()->stock);
    }

    /** @test */
    public function the_parent_stock_will_be_reduced_if_the_stock_is_inherited()
    {
        $product = $this->makeProduct();
        $variant = create(Variant::class, [
            'inherit_stock' => true,
            'product_slug'  => $product->slug,
        ])->first();

        $productStock = $product->stock;
        $variantStock = $variant->original_stock;

        $item = (new Item($variant->slug));
        $item->setQuantity(2);

        $collection = new ItemCollection(collect()->push($item));

        $order = create(Order::class, [
            'id'    => 'tr_fake_id',
            'items' => $collection->items,
        ])->first();

        $this->assertEquals($productStock, Product::find($product->slug)->stock);
        $this->assertEquals($variantStock, Variant::first()->original_stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $this->assertEquals($variantStock, Variant::first()->original_stock);
        $this->assertEquals($productStock - 2, Product::find($product->slug)->stock);
    }

    /** @test */
    public function the_prodcut_stock_wont_be_reduced_on_unlimited_products()
    {
        $order = create(Order::class, ['number' => 'tr_fake_id'])->first();

        $product = $this->makeProduct();
        $entry = Entry::findBySlug($product->slug, 'products');
        $entry->set('stock_unlimited', true)->save();

        $stock = $product->stock;

        $this->assertEquals($stock, $product->stock);

        $this->mockMollie(new MolliePaymentSuccessful());
        $this->post(route('butik.payment.webhook.mollie'), ['id' => $order->id]);

        $this->assertEquals($stock, Product::find($product->slug)->stock);
    }

    public function mockMollie($mock)
    {
        Mollie::shouldReceive('api->orders->get')
            ->andReturn($mock);
    }
}
