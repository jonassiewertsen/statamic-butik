<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class ProductsController extends Controller
{
    public function index() {
        // TODO: Do not use all !!!
        $products = Product::all()->filter(function ($collection) {
            return true;
            // TODO: Add permissions
            //return User::current()->can('view', $collection);
        })->map(function ($product) {
            return [
                'title' => $product->title,
                'slug' => $product->slug,
                'images' => $product->images[0] ?? null,
                'description' => $product->description,
                'base_price' => $product->base_price_with_currency_symbol,

                // TODO: Add edit url
                // 'edit_url' => $collection->editUrl(),

                // TODO: Add permissions
                // 'deleteable' => User::current()->can('delete', $collection)
                'deleteable' => true,

            ];
        })->values();

        return view('statamic-butik::products.index', [
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
        $blueprint = new ProductBlueprint();

        $fields = $blueprint()->fields()->preProcess();

        return view('statamic-butik::products.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string',
            'slug'        => 'required|string|unique:products,slug',
            'description' => 'required',
            'images'      => 'required',
            'base_price'  => 'required|integer|min:0',
            'type'        => 'required|string',
        ]);

        Product::create($validatedData);
    }

    public function destroy(Product $product) {
        // TODO: Add Permissions
        $product->delete();
    }
}
