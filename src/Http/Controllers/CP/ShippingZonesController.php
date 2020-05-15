<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingZoneBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\CP\Column;

class ShippingZonesController extends CpController
{
//    public function index()
//    {
//        $this->authorize('index', ShippingZone::class);
//
//        $shippings = ShippingZone::all()->map(function ($shipping) {
//            return [
//                'title'      => $shipping->title,
//                'price'      => $shipping->priceWithCurrencySymbol,
//                'edit_url'   => $shipping->editUrl(),
//                'slug'       => $shipping->slug,
//                'deleteable' => auth()->user()->can('delete', $shipping),
//            ];
//        })->values();
//
//        return view('butik::cp.shippings.index', [
//            'shippings' => $shippings,
//            'columns' => [
//                Column::make('title')->label(__('butik::shipping.singular')),
//                Column::make('price')->label(__('butik::shipping.price')),
//            ],
//        ]);
//    }
//
//    public function create()
//    {
//        $this->authorize('create', ShippingZone::class);
//
//        $blueprint = new ShippingBlueprint();
//        $fields = $blueprint()->fields()->preProcess();
//
//        return view('butik::cp.shippings.create', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'meta'      => $fields->meta(),
//        ]);
//    }

    public function store(Request $request)
    {
//        $this->authorize('store', ShippingZone::class); TODO: Add authorization

        $blueprint = new ShippingZoneBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingZone::create($values->toArray());
    }

//    public function edit(Shipping $shipping)
//    {
//        $this->authorize('edit', $shipping);
//
//        $values = $shipping->toArray();
//        $blueprint = new ShippingBlueprint();
//        $fields = $blueprint()->fields()->addValues($values)->preProcess();
//
//        return view('butik::cp.shippings.edit', [
//            'blueprint' => $blueprint()->toPublishArray(),
//            'values'    => $fields->values(),
//            'id'        => $shipping->slug,
//            'meta'      => $fields->meta(),
//        ]);
//    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
//        $this->authorize('update', $shippingProfile);

        $blueprint = new ShippingZoneBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shippingZone->update($values->toArray());
    }

    public function destroy(ShippingZone $shippingZone)
    {
//        $this->authorize('delete', $shippingProfile);

        $shippingZone->delete();
    }
}
