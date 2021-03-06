<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\Butik\Blueprints\ShippingRateBlueprint;
use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\ShippingRate;

class ShippingRatesController extends CpController
{
    public function store(Request $request)
    {
        $this->authorize('store', ShippingRate::class);

        $blueprint = new ShippingRateBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingRate::create($values->toArray());
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $this->authorize('update', $shippingRate);

        $blueprint = new ShippingRateBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shippingRate->update($values->toArray());
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $this->authorize('delete', $shippingRate);

        $shippingRate->delete();
    }
}
