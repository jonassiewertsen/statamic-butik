<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class VariantBlueprint extends Blueprint
{
    public function __invoke()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'available',
                            'field'  => [
                                'type'     => 'toggle',
                                'width'    => 25,
                                'default'  => true,
                                'display'  => __('butik::cp.available'),
                            ],
                        ],
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'       => 'text',
                                'width'      => 75,
                                'display'    => __('butik::cp.name'),
                                'validate'   => 'required',
                            ],
                        ],
                        [
                            'handle' => 'price_section',
                            'field'  => [
                                'type'    => 'section',
                                'display' => ucfirst(__('butik::cp.price_section')),
                            ],
                        ],
                        [
                            'handle' => 'inherit_price',
                            'field'  => [
                                'type'    => 'toggle',
                                'default' => true,
                                'width'   => 25,
                                'display' => __('butik::cp.link_price'),
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'     => 'money',
                                'width'    => 75,
                                'display'  => __('butik::cp.price'),
                                'validate' => 'nullable',
                                'unless'   => [
                                    'inherit_price' => 'equals true',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'stock_section',
                            'field'  => [
                                'type'    => 'section',
                                'display' => ucfirst(__('butik::cp.stock_section')),
                            ],
                        ],
                        [
                            'handle' => 'inherit_stock',
                            'field'  => [
                                'type'    => 'toggle',
                                'default' => false,
                                'width'   => 25,
                                'display' => __('butik::cp.inherit_stock'),
                            ],
                        ],
                        [
                            'handle' => 'stock',
                            'field'  => [
                                'type'       => 'integer',
                                'width'      => 50,
                                'default'    => 0,
                                'display'    => __('butik::cp.stock'),
                                'validate'   => 'nullable',
                                'unless_any' => [
                                    'inherit_stock'   => 'equals true',
                                    'unlimited_stock' => 'equals true',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'stock_unlimited',
                            'field'  => [
                                'type'    => 'toggle',
                                'width'   => 25,
                                'display' => __('butik::cp.stock_unlimited'),
                                'unless'  => [
                                    'inherit_stock' => 'equals true',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'product_slug',
                            'field'  => [
                                'type'     => 'hidden',
                                'validate' => 'required',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
