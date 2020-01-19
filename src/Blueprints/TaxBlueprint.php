<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint;

class TaxBlueprint
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
                            'handle' => 'percentage',
                            'field'  => [
                                'type'         => 'integer',
                                'display'      => __('statamic-butik::cp.percentage'),
                                'width'         => '33',
                                'validate'      => 'required|integer|min:0|max:100',
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
                                'display'  => __('statamic-butik::cp.slug'),
                                'validate' => 'required|unique:butik_taxes,slug,id,'.request()->id,
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
        if (request()->route()->action['as'] === 'statamic.cp.butik.taxes.edit') {
            return true;
        }
        return false;
    }
}
