<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingZoneBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;

class ShippingZonesController extends CpController
{
    public function store(Request $request)
    {
        $this->authorize('store', ShippingZone::class);

        $blueprint = new ShippingZoneBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingZone::create($values->toArray());
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $this->authorize('update', $shippingZone);

        $blueprint = new ShippingZoneBlueprint($shippingZone);
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shippingZone->update($values->toArray());
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $this->authorize('delete', $shippingZone);

        $shippingZone->delete();
    }
}
