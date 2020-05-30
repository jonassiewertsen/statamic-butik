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
//        $this->authorize('index', Shipping::class);

        $shippingProfileBlueprint = new ShippingProfileBlueprint();
        $shippingProfileFields    = $shippingProfileBlueprint()->fields()->preProcess();

        $shippingZoneBlueprint = new ShippingZoneBlueprint();
        $shippingZoneFields    = $shippingZoneBlueprint()->fields()->preProcess();

        $shippingRateBlueprint = new ShippingRateBlueprint();
        $shippingRateFields    = $shippingRateBlueprint()->fields()->preProcess();

        return view('butik::cp.shipping.index', [
            'shippingProfiles' => ShippingProfile::all(),

            'shippingProfileBlueprint' => $shippingProfileBlueprint()->toPublishArray(),
            'shippingProfileValues'    => $shippingProfileFields->values(),
            'shippingProfileMeta'      => $shippingProfileFields->meta(),

            'shippingZoneBlueprint' => $shippingZoneBlueprint()->toPublishArray(),
            'shippingZoneValues'    => $shippingZoneFields->values(),
            'shippingZoneMeta'      => $shippingZoneFields->meta(),

            'shippingRateBlueprint' => $shippingRateBlueprint()->toPublishArray(),
            'shippingRateValues'    => $shippingRateFields->values(), // needed ?
            'shippingRateMeta'      => $shippingRateFields->meta(), // needed ?
        ]);
    }
}
