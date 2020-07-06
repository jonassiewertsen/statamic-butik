<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Rules\VariantPriceRule;
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
                                'display'  => __('butik::product.available'),
                            ],
                        ],
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'       => 'text',
                                'width'      => 75,
                                'display'    => __('butik::variant.title'),
                                'validate'   => 'required',
                            ],
                        ],
                        [
                            'handle' => 'price_section',
                            'field'  => [
                                'type'    => 'section',
                                'display' => __('butik::price_section'),
                            ],
                        ],
                        [
                            'handle' => 'inherit_price',
                            'field'  => [
                                'type'    => 'toggle',
                                'default' => true,
                                'width'   => 25,
                                'display' => __('butik::link_price'),
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'     => 'money',
                                'width'    => 75,
                                'display'  => __('butik::product.price'),
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
                                'display' => __('butik::stock_section'),
                            ],
                        ],
                        [
                            'handle' => 'inherit_stock',
                            'field'  => [
                                'type'    => 'toggle',
                                'default' => false,
                                'width'   => 25,
                                'display' => __('butik::link_stock'),
                            ],
                        ],
                        [
                            'handle' => 'stock',
                            'field'  => [
                                'type'       => 'integer',
                                'width'      => 50,
                                'default'    => 0,
                                'display'    => __('butik::product.stock'),
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
                                'display' => __('butik::stock_unlimited'),
                                'unless'  => [
                                    'inherit_stock' => 'equals true',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'product_slug',
                            'field'  => [
                                'type'     => 'hidden',
                                'validate' => 'required|exists:butik_products,slug',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
