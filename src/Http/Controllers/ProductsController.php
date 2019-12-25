<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Facades\Blueprint;

class ProductsController extends Controller
{
    public function create()
    {

        // TODO: Do i want to extract this Blueprint into its own class? Yeah, i think so ...
        $blueprint = Blueprint::make()->setContents([

            'sections' => [
                'main'    => [
                    'fields' => [
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'    => 'text',
                                'display' => __('statamic-butik::product.form.creating.title'),
                            ],
                        ],
                        [
                            'handle' => 'description',
                            'field'  => [
                                'type'    => 'bard',
                                'display' => __('statamic-butik::product.form.creating.description'),
                                'buttons' => [
                                    'h2', 'bold', 'italic', 'underline', 'strikethrough', 'unorderedlist', 'orderedlist', 'anchor', 'quote',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'images',
                            'field'  => [
                                'type'    => 'assets',
                                'mode' => 'list',
                                'display' => __('statamic-butik::product.form.creating.images'),
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'fields' => [
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'    => 'slug',
                                'display' => __('statamic-butik::product.form.creating.slug'),
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $fields = $blueprint->fields()->preProcess();

        return view('statamic-butik::products.create', [
            'blueprint' => $blueprint->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public
    function store(Request $request)
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
