<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class ShippingBlueprint extends Blueprint
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
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'         => 'money',
                                'display'      => __('butik::cp.price'),
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
                                'display'  => __('butik::cp.slug'),
                                'validate' => ['required', $this->shippingUniqueRule()],
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
        return $this->isRoute('statamic.cp.butik.shippings.edit');
    }

    private function shippingUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_shippings',
            'slug',
            'statamic.cp.butik.shippings.update'
        );
    }
}
