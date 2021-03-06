<?php

namespace Jonassiewertsen\Butik\Blueprints;

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
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'minimum',
                            'field'  => [
                                'type'         => 'integer',
                                'default'      => 0,
                                'display'      => __('butik::cp.minimum'),
                                'instructions' => __('butik::cp.shipping_minimum_description'),
                                'validate'     => 'required|numeric|min:0',
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'     => 'money',
                                'display'  => __('butik::cp.price'),
                                'validate' => 'required|min:0',
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
