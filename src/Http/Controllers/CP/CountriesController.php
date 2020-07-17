<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\CountryBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Country;
use Statamic\CP\Column;

class CountriesController extends CpController
{
    public function index()
    {
        $this->authorize('index', Country::class);

        $countries = Country::all()->map(function ($country) {
            return [
                'name'       => $country->name,
                'iso'        => $country->iso,
                'slug'       => $country->slug,
                'edit_url'   => $country->editUrl,
                'deleteable' => auth()->user()->can('delete', $country),
            ];
        })->values();

        return view('butik::cp.countries.index', [
            'countries' => $countries,
            'columns'   => [
                Column::make('name')->label(ucfirst(__('butik::cp.country_singular'))),
                Column::make('iso')->label(ucfirst(__('butik::cp.country_iso'))),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Country::class);

        $blueprint = new CountryBlueprint();
        $fields    = $blueprint()->fields()->preProcess();

        return view('butik::cp.countries.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('store', Country::class);

        $blueprint = new CountryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Country::create($values->toArray());
    }

    public function edit(Country $country)
    {
        $this->authorize('edit', $country);

        $values    = $country->toArray();
        $blueprint = new CountryBlueprint();
        $fields    = $blueprint()->fields()->addValues($values)->preProcess();

        return view('butik::cp.countries.edit', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function update(Request $request, Country $country)
    {
        $this->authorize('update', $country);

        $blueprint = new CountryBlueprint();
        $fields    = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $country->update($values->toArray());
    }

    public function destroy(Country $country)
    {
        $this->authorize('delete', $country);

        $country->delete();
    }
}
