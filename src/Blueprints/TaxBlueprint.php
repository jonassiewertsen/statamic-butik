<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class TaxBlueprint extends Blueprint
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
                            'handle' => 'percentage',
                            'field'  => [
                                'type'         => 'number',
                                'display'      => __('butik::cp.percentage'),
                                'width'         => '33',
                                'validate'      => 'required|numeric|min:0|max:100',
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
                                'validate' => ['required', $this->taxesUniqueRule()],
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
        return $this->isRoute('statamic.cp.butik.taxes.edit');
    }

    private function taxesUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_taxes',
            'slug',
            'statamic.cp.butik.taxes.update'
        );
    }
}
