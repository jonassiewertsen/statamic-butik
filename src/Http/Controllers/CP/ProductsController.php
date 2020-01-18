<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\CP\Column;

class ProductsController extends CpController
{
    public function index()
    {
        $this->authorize('index', Product::class);

        $products = Product::all()->map(function ($product) {
            return [
                'title' => $product->title,
                'slug' => $product->slug,
                'images' => $product->images[0] ?? null,
                'description' => $product->description,
                'base_price' => $product->base_price_with_currency_symbol,
                'edit_url' => $product->editUrl,
                'deleteable' => auth()->user()->can('delete', $product),
            ];
        })->values();

        return view('statamic-butik::cp.products.index', [
            'products' => $products,
            'columns' => [
                Column::make('title')->label(__('statamic-butik::product.form.title')),
                Column::make('base_price')->label(__('statamic-butik::product.form.base_price')),
                // TODO: Show Image !
//                Column::make('images')->label(__('statamic-butik::product.form.images')),
                Column::make('slug')->label(__('statamic-butik::product.form.slug')),
                // TODO: Parse description into array
//                Column::make('description')->label(__('statamic-butik::product.form.description')),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Product::class);

        $blueprint = new ProductBlueprint();
        $fields = $blueprint()->fields()->preProcess();

        return view('statamic-butik::cp.products.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('store', Product::class);

        $blueprint = new ProductBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Product::create($values->toArray());
    }

    public function edit(Product $product)
    {
        $this->authorize('edit', Product::class);

        $values = $product->toArray();
        $blueprint = new ProductBlueprint();
        $fields = $blueprint()->fields()->addValues($values)->preProcess();

        return view('statamic-butik::cp.products.edit', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', Product::class);

        $blueprint = new ProductBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $product->update($values->toArray());
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);

        // TODO: Only deletable if ?
        $product->delete();
    }
}
