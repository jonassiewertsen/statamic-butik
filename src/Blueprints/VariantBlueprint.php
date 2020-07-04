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
                                'display'  => __('butik::product.available'),
                                'validate' => '',
                            ],
                        ],
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'       => 'text',
                                'input_type' => 'text',
                                'width'      => 75,
                                'display'    => __('butik::product.title'),
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
                                'type'    => 'money',
                                'width'   => 75,
                                'display' => __('butik::product.price'),
                                'validate' => 'nullable',
                                'unless'  => [
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
                                'default' => true,
                                'width'   => 25,
                                'display' => __('butik::link_stock'),
                            ],
                        ],
                        [
                            'handle' => 'stock',
                            'field'  => [
                                'type'       => 'integer',
                                'width'      => 50,
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

//    /**
//     * In case the Product will be edited, the slug will be read only
//     */
//    private function slugReadOnly(): bool {
//        return $this->isRoute('statamic.cp.butik.products.edit');
//    }
//
//    private function fetchTaxOptions(): array {
//        return Tax::pluck('title', 'slug')->toArray();
//    }
//
//    private function fetchShippingOptions(): array {
//        return ShippingProfile::pluck('title', 'slug')->toArray();
//    }
//
//    private function productUniqueRule() {
//        return $this->ignoreUnqiueOn(
//            'butik_products',
//            'slug',
//            'statamic.cp.butik.products.update'
//        );
//    }
}
