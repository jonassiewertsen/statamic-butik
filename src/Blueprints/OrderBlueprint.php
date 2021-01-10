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
                            'handle' => 'name',
                            'field'  => [
                                'type'     => 'text',
                                'listable' => true,
                                'display'  => __('butik::cp.name'),
                            ],
                        ],
                        [
                            'handle' => 'email',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::cp.email'),
                            ],
                        ],
                        [
                            'handle' => 'status',
                            'field'  => [
                                'type'     => 'text',
                                'listable' => true,
                                'display'  => __('butik::cp.status'),
                            ],
                        ],
                        [
                            'handle' => 'id',
                            'field'  => [
                                'type'     => 'text',
                                'listable' => true,
                                'display'  => __('butik::cp.id'),
                            ],
                        ],
                        [
                            'handle' => 'number',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::cp.order_number'),
                            ],
                        ],
                        [
                            'handle' => 'method',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::cp.method'),
                            ],
                        ],
                        [
                            'handle' => 'items_count',
                            'field'  => [
                                'type'     => 'number',
                                'display'  => __('butik::cp.items_count'),
                            ],
                        ],
                        [
                            'handle' => 'total_amount',
                            'field'  => [
                                'type'     => 'money',
                                'listable' => true,
                                'display'  => __('butik::cp.total_amount'),
                            ],
                        ],
                        [
                            'handle' => 'date',
                            'field'  => [
                                'type'     => 'date',
                                'listable' => true,
                                'display'  => __('butik::cp.ordered_at'),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
