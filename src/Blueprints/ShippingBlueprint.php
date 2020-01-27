<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint;

class ShippingBlueprint
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
                                'width'    => '66',
                                'display'  => __('butik::general.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'         => 'money',
                                'display'      => __('butik::shipping.price'),
                                'width'         => '33',
                                'validate'      => 'required|min:0',
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'fields' => [
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'     => 'slug',
                                'display'  => __('butik::general.slug'),
                                'validate' => 'required|unique:butik_shippings,slug,id,'.request()->id,
                                'read_only' => $this->slugReadOnly(),
                            ],
                        ],
                    ]
                ]
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
}
