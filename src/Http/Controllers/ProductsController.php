<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Models\Product;

class ProductsController extends Controller
{
    public function create()
    {
        return view('statamic-butik::products.create');
    }

    public
    function store(Request $request)
    {
        Product::create($request->all());
    }

// TODO: Validation for the input data
}
