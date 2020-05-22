<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Blueprints\ShippingProfileBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;

class ShippingController extends CpController
{
    public function index()
    {
//        $this->authorize('index', Shipping::class);

        $shippingBlueprint = new ShippingProfileBlueprint();
        $shippingFields    = $shippingBlueprint()->fields()->preProcess();

        return view('butik::cp.shipping.index', [
            'shippingProfiles'  => ShippingProfile::all(),
            'shippingBlueprint' => $shippingBlueprint()->toPublishArray(),
            'shippingValues'    => $shippingFields->values(),
            'shippingMeta'      => $shippingFields->meta(),
        ]);
    }
}
