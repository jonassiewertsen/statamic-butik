<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\TaxBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class TaxesController extends Controller
{
    // TODO: !
//    public function index() {
//        // TODO: Do not use all !!!
//        $taxes = Tax::all()->filter(function ($collection) {
//            return true;
//            // TODO: Add permissions
//            //return User::current()->can('view', $collection);
//        })->map(function ($tax) {
//            return [
//                'title' => $tax->title,
//                'slug' => $tax->slug,
//                'images' => $tax->images[0] ?? null,
//                'description' => $tax->description,
//                'base_price' => $tax->base_price_with_currency_symbol,
//                'edit_url' => $tax->editUrl(),
//
//                // TODO: Add permissions
//                // 'deleteable' => User::current()->can('delete', $collection)
//                'deleteable' => true,
//
//            ];
//        })->values();
//
//        return view('statamic-butik::cp.Taxs.index', [
//            'products' => $taxes,
//            'columns' => [
//                Column::make('title')->label(__('statamic-butik::product.form.title')),
//                Column::make('base_price')->label(__('statamic-butik::product.form.base_price')),
//                // TODO: Show Image !
////                Column::make('images')->label(__('statamic-butik::product.form.images')),
//                Column::make('slug')->label(__('statamic-butik::product.form.slug')),
//                // TODO: Parse description into array
////                Column::make('description')->label(__('statamic-butik::product.form.description')),
//            ],
//        ]);
//    }

    // TODO: !
//    public function create()
//    {
//        $blueprint = new TaxBlueprint();
//        $fields = $blueprint()->fields()->preProcess();
//
//        return view('statamic-butik::cp.products.create', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'meta'      => $fields->meta(),
//        ]);
//    }

    public function store(Request $request)
    {
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Tax::create($values->toArray());
    }

    // TODO: !
//    public function edit(Product $tax) {
//        $values = $tax->toArray();
//        $blueprint = new TaxBlueprint();
//        $fields = $blueprint()->fields()->addValues($values)->preProcess();
//
//        return view('statamic-butik::cp.products.edit', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'meta'      => $fields->meta(),
//        ]);
//    }

    public function update(Request $request, Tax $tax) {
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $tax->update($values->toArray());
    }

    public function destroy(Tax $tax)
    {
        // TODO: Add Permissions
        $tax->delete();
    }
}
