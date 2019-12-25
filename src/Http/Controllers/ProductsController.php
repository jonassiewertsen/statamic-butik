<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Facades\Blueprint;

class ProductsController extends Controller
{
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
            'description' => 'nullable',
            'images'      => 'required',
        ]);

        Product::create($validatedData);
    }
}
