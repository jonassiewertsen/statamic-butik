<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

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
                                'type'    => 'text',
                                'display' => __('statamic-butik::product.form.creating.title'),
                            ],
                        ],
                        [
                            'handle' => 'description',
                            'field'  => [
                                'type'    => 'bard',
                                'display' => __('statamic-butik::product.form.creating.description'),
                                'buttons' => [
                                    'h2', 'bold', 'italic', 'underline', 'strikethrough', 'unorderedlist', 'orderedlist', 'anchor', 'quote',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'images',
                            'field'  => [
                                'type'    => 'assets',
                                'mode' => 'list',
                                'display' => __('statamic-butik::product.form.creating.images'),
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'fields' => [
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'    => 'slug',
                                'display' => __('statamic-butik::product.form.creating.slug'),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
