<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\Butik\Blueprints\TaxBlueprint;
use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\Tax;
use Statamic\CP\Column;

class TaxesController extends CpController
{
    public function index()
    {
        $this->authorize('index', Tax::class);

        $taxes = Tax::all()->map(function ($tax) {
            return [
                'title'      => $tax->title,
                'percentage' => $tax->percentage,
                'edit_url'   => $tax->editUrl(),
                'slug'         => $tax->slug,
                'deleteable' => auth()->user()->can('delete', $tax),
            ];
        })->values();

        return view('butik::cp.taxes.index', [
            'taxes' => $taxes,
            'columns' => [
                Column::make('title')->label(__('butik::cp.tax_singular')),
                Column::make('percentage')->label(__('butik::cp.percentage')),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Tax::class);

        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->preProcess();

        return view('butik::cp.taxes.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('store', Tax::class);

        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Tax::create($values->toArray());
    }

    public function edit(Tax $tax)
    {
        $this->authorize('edit', $tax);

        $values = $tax->toArray();
        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($values)->preProcess();

        return view('butik::cp.taxes.edit', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'slug'        => $tax->slug,
            'meta'      => $fields->meta(),
        ]);
    }

    public function update(Request $request, Tax $tax)
    {
        $this->authorize('update', $tax);

        $blueprint = new TaxBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $tax->update($values->toArray());
    }

    public function destroy(Tax $tax)
    {
        $this->authorize('delete', $tax);

        if ($this->usedByProducts($tax)) {
            return response('You can\'t delete this tax. It is used by some products', 403);
        }

        $tax->delete();
    }

    private function usedByProducts($tax)
    {
        return $tax->products->count() !== 0;
    }
}
