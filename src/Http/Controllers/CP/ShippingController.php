<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Blueprints\ShippingProfileBlueprint;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingRateBlueprint;
use Jonassiewertsen\StatamicButik\Blueprints\ShippingZoneBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingController extends CpController
{
    public function index()
    {
        $this->authorize('index', ShippingProfile::class);

        $shippingProfileBlueprint = new ShippingProfileBlueprint();
        $shippingProfileFields    = $shippingProfileBlueprint()->fields()->preProcess();

        $shippingZoneBlueprint = new ShippingZoneBlueprint();
        $shippingZoneFields    = $shippingZoneBlueprint()->fields()->preProcess();

        $shippingRateBlueprint = new ShippingRateBlueprint();
        $shippingRateFields    = $shippingRateBlueprint()->fields()->preProcess();

        return view('butik::cp.shipping.index', [
            'shippingProfiles' => ShippingProfile::all(),

            'shippingProfileBlueprint' => $shippingProfileBlueprint()->toPublishArray(),
            'shippingProfileFields' => $shippingProfileFields,

            'shippingZoneBlueprint' => $shippingZoneBlueprint()->toPublishArray(),
            'shippingZoneFields' => $shippingZoneFields,

            'shippingRateBlueprint' => $shippingRateBlueprint()->toPublishArray(),
            'shippingRateFields' => $shippingRateFields,
        ]);
    }
}
