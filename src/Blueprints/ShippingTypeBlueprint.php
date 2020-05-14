<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class ShippingTypeBlueprint extends Blueprint
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
                                'width'    => '66',
                                'display'  => __('butik::general.title'),
                                'validate' => 'required',
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
                                'validate' => ['required', $this->shippingtypeUniqueRule()],
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
    private function slugReadOnly(): bool
    {
        return $this->isRoute('statamic.cp.butik.shipping-types.edit');
    }

    private function shippingtypeUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_shipping_types',
            'slug',
            'statamic.cp.butik.shipping-types.update'
        );
    }
}
