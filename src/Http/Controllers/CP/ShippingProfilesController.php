<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Illuminate\Http\Request;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingProfileBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingProfilesController extends CpController
{
    public function index()
    {
        $this->authorize('index', ShippingProfile::class);

        return ShippingProfile::all()->map(function ($shipping) {
            return [
                'title' => $shipping->title,
                'slug'  => $shipping->slug,
                'zones' => $shipping->zones,
            ];
        })->toArray();
    }

    public function show(ShippingProfile $shippingProfile)
    {
        $this->authorize('show', ShippingProfile::class);

        return $shippingProfile->load('zones.rates');
    }

    public function store(Request $request)
    {
        $this->authorize('store', ShippingProfile::class);

        $blueprint = new ShippingProfileBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        ShippingProfile::create($values->toArray());
    }

    public function update(Request $request, ShippingProfile $shippingProfile)
    {
        $this->authorize('update', $shippingProfile);

        $blueprint = new ShippingProfileBlueprint();
        $fields = $blueprint()->fields()->addValues($request->all());
        $fields->validate();
        $values = $fields->process()->values();
        $shippingProfile->update($values->toArray());
    }

    public function destroy(ShippingProfile $shippingProfile)
    {
        $this->authorize('delete', $shippingProfile);

        if ($this->areProductsRelated($shippingProfile)) {
            return abort('403', 'You can\'t delete this shipping profile, if related to a product.');
        }

        $shippingProfile->delete();
    }

    private function areProductsRelated($shippingProfile): bool
    {
        return Product::where('shipping_profile_slug', $shippingProfile->slug)->get()->count() > 0;
    }
}
