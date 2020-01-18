<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\TaxBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class TaxesController extends CpController
{

    public function index() {
        $taxes = Tax::all()->filter(function ($collection) {
            return true;
            // TODO: Add permissions
            //return User::current()->can('view', $collection);
        })->map(function ($tax) {
            return [
                'title'      => $tax->title,
                'percentage' => $tax->percentage,
                'edit_url'   => $tax->editUrl(),
                'slug'         => $tax->slug,

                // TODO: Add permissions
                // 'deleteable' => User::current()->can('delete', $collection)
                'deleteable' => true,
            ];
        })->values();

        return view('statamic-butik::cp.taxes.index', [
            'taxes' => $taxes,
            'columns' => [
                Column::make('title')->label(__('statamic-butik::tax.singular')),
                Column::make('percentage')->label(__('statamic-butik::cp.percentage')),
            ],
        ]);
    }

    public function create()
    {
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->preProcess();

        return view('statamic-butik::cp.taxes.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Tax::create($values->toArray());
    }

    public function edit(Tax $tax) {
        $values = $tax->toArray();
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($values)->preProcess();

        return view('statamic-butik::cp.taxes.edit', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'slug'        => $tax->slug,
            'meta'      => $fields->meta(),
        ]);
    }

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
