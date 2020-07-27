<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Facades\Blueprint as StatamicBlueprint;

class ProductBlueprint extends Blueprint
{
    public function __invoke()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main'    => [
                    'fields' => [
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::cp.product_singular'),
                                'validate' => 'required|string',
                            ],
                        ],
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'          => 'slug',
                                'display'       => __('butik::cp.slug'),
                                'instructions'  => __('butik::cp.slug_description'),
                                'validate'      => ['required', 'string', $this->productUniqueRule() ],
                                'read_only'     => $this->slugReadOnly(),
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'          => 'money',
                                'display'       => __('butik::cp.price'),
                                'width'         => '25',
                                'validate'      => 'required|min:0',
                            ],
                        ],
                        [
                            'handle' => 'tax_id',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('butik::cp.tax_singular'),
                                'options'      => $this->fetchTaxOptions(),
                                'width'         => '25',
                                'validate'      => 'required|exists:butik_taxes,slug'
                            ],
                        ],
                        [
                            'handle' => 'shipping_profile_slug',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('butik::cp.shipping_singular'),
                                'options'      => $this->fetchShippingOptions(),
                                'width'         => '25',
                                'validate'      => 'required|exists:butik_shipping_profiles,slug'
                            ],
                        ],
                        [
                            'handle' => 'type',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('butik::cp.type'),
                                'width'         => '25',
                                'default' => 'physical',
                                'options' => [
                                    'physical' => 'physical',
                                ],
                                'validate'     => 'required|string',
                            ],
                        ],
                        [
                            'handle' => 'images',
                            'field'  => [
                                'type'     => 'assets',
                                'display'  => __('butik::cp.images'),
                                'validate' => 'nullable',
                                'mode'     => 'grid',
                            ],
                        ],
                        [
                            'handle' => 'description',
                            'field'  => [
                                'type'    => 'textarea',
                                'display' => __('butik::cp.description'),
                                'validate' => 'nullable',
                                'buttons' => [
                                    'h2', 'bold', 'italic', 'underline', 'strikethrough', 'unorderedlist', 'orderedlist', 'anchor', 'quote',
                                ],
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'fields' => [
                        [
                            'handle' => 'available',
                            'field'  => [
                                'type'     => 'toggle',
                                'default'  => true,
                                'display'  => __('butik::cp.available'),
                                'validate' => 'required|boolean',
                            ],
                        ],
                        [
                            'handle' => 'stock',
                            'field'  => [
                                'type'     => 'integer',
                                'width'    => '50',
                                'default'  => 0,
                                'display'  => __('butik::cp.stock'),
                                'validate' => 'required|integer',
                                'unless'    => [
                                    'stock_unlimited' => true,
                                ],
                            ],
                        ],
                        [
                            'handle' => 'stock_unlimited',
                            'field'  => [
                                'type'     => 'toggle',
                                'width'    => '50',
                                'display'  => __('butik::cp.stock_unlimited'),
                                'validate' => 'required|boolean',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * In case the Product will be edited, the slug will be read only
     */
    private function slugReadOnly(): bool {
        return $this->isRoute('statamic.cp.butik.products.edit');
    }

    private function fetchTaxOptions(): array {
        return Tax::pluck('title', 'slug')->toArray();
    }

    private function fetchShippingOptions(): array {
        return ShippingProfile::pluck('title', 'slug')->toArray();
    }

    private function productUniqueRule() {
        return $this->ignoreUnqiueOn(
            'butik_products',
            'slug',
            'statamic.cp.butik.products.update'
        );
    }
}
