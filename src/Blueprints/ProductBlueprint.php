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
                                'type'     => 'text',
                                'display'  => __('statamic-butik::product.form.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'         => 'slug',
                                'display'      => __('statamic-butik::product.form.slug'),
                                'validate'     => 'required',
                                'instructions' => __('statamic-butik::product.form.slug_description'),
                            ],
                        ],
                        [
                            'handle' => 'description',
                            'field'  => [
                                'type'    => 'bard',
                                'display' => __('statamic-butik::product.form.description'),
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
                            'handle' => 'images',
                            'field'  => [
                                'type'     => 'assets',
                                'display'  => __('statamic-butik::product.form.images'),
                                'validate' => 'required',
                                'mode'     => 'grid',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
