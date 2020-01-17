<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Statamic\Contracts\Auth\User;
use Statamic\CP\Column;
use Statamic\Facades\Blueprint;

class ShippingsController extends Controller
{

    public function index() {
        $shippings = Shipping::all()->filter(function ($collection) {
            return true;
            // TODO: Add permissions
            //return User::current()->can('view', $collection);
        })->map(function ($shipping) {
            return [
                'title'      => $shipping->title,
                'price'      => $shipping->price,
                'edit_url'   => $shipping->editUrl(),
                'id'         => $shipping->id,

                // TODO: Add permissions
                // 'deleteable' => User::current()->can('delete', $collection)
                'deleteable' => true,
            ];
        })->values();

        return view('statamic-butik::cp.shippings.index', [
            'shippings' => $shippings,
            'columns' => [
                Column::make('title')->label(__('statamic-butik::shipping.singular')),
                Column::make('price')->label(__('statamic-butik::cp.price')),
            ],
        ]);
    }

    public function create()
    {
        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->preProcess();

        return view('statamic-butik::cp.shippings.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Shipping::create($values->toArray());
    }

//    public function edit(Tax $tax) {
//        $values = $tax->toArray();
//        $blueprint = new TaxBlueprint();
//        $fields = $blueprint()->fields()->addValues($values)->preProcess();
//
//        return view('statamic-butik::cp.taxes.edit', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'id'        => $tax->id,
//            'meta'      => $fields->meta(),
//        ]);
//    }

    public function update(Request $request, Shipping $shipping) {
        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shipping->update($values->toArray());
    }

    public function destroy(Shipping $shipping)
    {
        // TODO: Add Permissions
        $shipping->delete();
    }
}
