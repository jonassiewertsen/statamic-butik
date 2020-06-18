<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\ShippingZone;
use Statamic\Facades\Blueprint as StatamicBlueprint;

class ShippingRateBlueprint extends Blueprint
{
    public function __invoke()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::general.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'minimum',
                            'field'  => [
                                'type'         => 'integer',
                                'default'      => 0,
                                'display'      => __('butik::shipping.minimum'),
                                'instructions' => __('butik::shipping.minimum_instructions'),
                                'validate'     => 'required|numeric|min:0',
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'     => 'money',
                                'display'  => __('butik::product.base_price'),
                                'validate' => 'required|string|min:0',
                            ],
                        ],
                        [
                            'handle' => 'shipping_zone_id',
                            'field'  => [
                                'type'     => 'hidden',
                                'validate' => 'required|exists:butik_shipping_zones,id',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
