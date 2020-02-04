<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Statamic\CP\Column;

class ShippingsController extends CpController
{
    public function index()
    {
        $this->authorize('index', Shipping::class);

        $shippings = Shipping::all()->map(function ($shipping) {
            return [
                'title'      => $shipping->title,
                'price'      => $shipping->priceWithCurrencySymbol,
                'edit_url'   => $shipping->editUrl(),
                'slug'       => $shipping->slug,
                'deleteable' => auth()->user()->can('delete', Shipping::class),
            ];
        })->values();

        return view('butik::cp.shippings.index', [
            'shippings' => $shippings,
            'columns' => [
                Column::make('title')->label(__('butik::shipping.singular')),
                Column::make('price')->label(__('butik::shipping.price')),
            ],
        ]);
    }

    public function create()
    {
        $this->authorize('create', Shipping::class);

        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->preProcess();

        return view('butik::cp.shippings.create', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'meta'      => $fields->meta(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('store', Shipping::class);

        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        Shipping::create($values->toArray());
    }

    public function edit(Shipping $shipping)
    {
        $this->authorize('edit', $shipping);

        $values = $shipping->toArray();
        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->addValues($values)->preProcess();

        return view('butik::cp.shippings.edit', [
            'blueprint' => $blueprint()->toPublishArray(),
            'values'    => $fields->values(),
            'id'        => $shipping->slug,
            'meta'      => $fields->meta(),
        ]);
    }

    public function update(Request $request, Shipping $shipping)
    {
        $this->authorize('update', $shipping);

        $blueprint = new ShippingBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shipping->update($values->toArray());
    }

    public function destroy(Shipping $shipping)
    {
        $this->authorize('delete', $shipping);

        if ($this->usedByProducts($shipping)) {
            return response('You can\'t delete this shipping. It is used by some products', 403);
        }

        $shipping->delete();
    }

    private function usedByProducts($shipping) {
        return $shipping->products->count() !== 0;
    }
}
