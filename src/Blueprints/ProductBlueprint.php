<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Jonassiewertsen\StatamicButik\Http\Models\Shipping;
use Jonassiewertsen\StatamicButik\Http\Models\Tax;
use Statamic\Facades\Blueprint;

class ProductBlueprint
{
    public function __invoke()
    {
        return Blueprint::make()->setContents([
            'sections' => [
                'main'    => [
                    'fields' => [
                        [
                            'handle' => 'title',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('statamic-butik::product.form.title'),
                                'validate' => 'required|string',
                            ],
                        ],
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'         => 'slug',
                                'display'      => __('statamic-butik::product.form.slug'),
                                'instructions' => __('statamic-butik::product.form.slug_description'),
                                'validate' => 'required|string|unique:butik_products,slug,id,'.request()->id,
                                'read_only' => $this->slugReadOnly(),
                            ],
                        ],
                        [
                            'handle' => 'base_price',
                            'field'  => [
                                'type'         => 'money',
                                'display'      => __('statamic-butik::product.form.base_price'),
                                'width'         => '25',
                                'validate'      => 'required|min:0',
                            ],
                        ],
                        [
                            'handle' => 'tax_id',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('statamic-butik::cp.taxes'),
                                'options'      => $this->fetchTaxOptions(),
                                'width'         => '25',
                                'validate'      => 'required|exists:butik_taxes,slug'
                            ],
                        ],
                        [
                            'handle' => 'shipping_id',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('statamic-butik::cp.shipping'),
                                'options'      => $this->fetchShippingOptions(),
                                'width'         => '25',
                                'validate'      => 'required|exists:butik_shippings,slug'
                            ],
                        ],
                        [
                            'handle' => 'type',
                            'field'  => [
                                'type'         => 'select',
                                'display'      => __('statamic-butik::product.form.type'),
                                'width'         => '25',
                                'default' => 'physical',
                                'options' => [
                                    'physical' => 'physical',
                                ],
                                'validate'     => 'required|string',
                            ],
                        ],
                        [
                            'handle' => 'description',
                            'field'  => [
                                'type'    => 'textarea',
                                'display' => __('statamic-butik::product.form.description'),
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
                                'display'  => __('statamic-butik::product.form.available'),
                                'validate' => 'required|boolean',
                            ],
                        ],
                        [
                            'handle' => 'images',
                            'field'  => [
                                'type'     => 'assets',
                                'display'  => __('statamic-butik::product.form.images'),
                                'validate' => 'nullable',
                                'mode'     => 'grid',
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
    private function slugReadOnly() {
        if (request()->route()->action['as'] === 'statamic.cp.butik.products.edit') {
            return true;
        }
        return false;
    }

    private function fetchTaxOptions() {
        return Tax::pluck('title', 'slug')->toArray();
    }

    private function fetchShippingOptions() {
        return Shipping::pluck('title', 'slug')->toArray();
    }
}
