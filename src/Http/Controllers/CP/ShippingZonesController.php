<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Illuminate\Http\Request;
use Jonassiewertsen\Butik\Blueprints\ShippingZoneBlueprint;
use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\ShippingZone;

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
