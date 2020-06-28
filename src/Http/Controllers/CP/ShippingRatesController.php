<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingRateBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingRate;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\CP\Column;

class ShippingRatesController extends CpController
{
    public function store(Request $request)
    {
//        $this->authorize('store', ShippingRate::class); TODO: Add authorization

        $blueprint = new ShippingRateBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingRate::create($values->toArray());
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
//        $this->authorize('update', $shippingProfile);

        $blueprint = new ShippingRateBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shippingRate->update($values->toArray());
    }

    public function destroy(ShippingRate $shippingRate)
    {
//        $this->authorize('delete', $shippingProfile);

        $shippingRate->delete();
    }
}
