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
                                'display'  => __('statamic-butik::cp.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'price',
                            'field'  => [
                                'type'         => 'integer',
                                'display'      => __('statamic-butik::cp.price'),
                                'width'         => '33',
                                'validate'      => 'required|integer|min:0',
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
}