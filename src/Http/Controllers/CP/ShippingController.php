<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Jonassiewertsen\Butik\Blueprints\ShippingProfileBlueprint;
use Jonassiewertsen\Butik\Blueprints\ShippingRateBlueprint;
use Jonassiewertsen\Butik\Blueprints\ShippingZoneBlueprint;
use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\ShippingProfile;

class ShippingController extends CpController
{
    public function index()
    {
        $this->authorize('index', ShippingProfile::class);

        $shippingProfileBlueprint = new ShippingProfileBlueprint();
        $shippingProfileFields = $shippingProfileBlueprint()->fields()->preProcess();

        $shippingZoneBlueprint = new ShippingZoneBlueprint();
        $shippingZoneFields = $shippingZoneBlueprint()->fields()->preProcess();

        $shippingRateBlueprint = new ShippingRateBlueprint();
        $shippingRateFields = $shippingRateBlueprint()->fields()->preProcess();

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
