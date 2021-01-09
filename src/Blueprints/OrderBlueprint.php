<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class OrderBlueprint extends Blueprint
{
    public function __invoke()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main'    => [
                    'fields' => [
                        [
                            'handle' => 'id',
                            'field'  => [
                                'type'     => 'text',
                                'width'    => '66',
                                'listable' => true,
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
