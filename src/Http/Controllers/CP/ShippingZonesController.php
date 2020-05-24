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
    public function store(Request $request)
    {
//        $this->authorize('store', ShippingZone::class); TODO: Add authorization

        $blueprint = new ShippingZoneBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingZone::create($values->toArray());
    }

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
