<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class CategoryBlueprint extends Blueprint
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
                                'width'    => '66',
                                'display'  => __('butik::cp.name'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'is_visible',
                            'field'  => [
                                'type'     => 'toggle',
                                'display'  => __('butik::cp.is_visible'),
                                'width'    => '33',
                                'default'  => true,
                                'validate' => 'sometimes',
                            ],
                        ],
                    ],
                ],
                'sidebar' => [
                    'fields' => [
                        [
                            'handle' => 'slug',
                            'field'  => [
                                'type'      => 'slug',
                                'from'      => 'name',
                                'display'   => __('butik::cp.slug'),
                                'validate'  => ['required', $this->categoryUniqueRule()],
                                'read_only' => $this->slugReadOnly(),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * In case the Product will be edited, the slug will be read only.
     */
    private function slugReadOnly(): bool
    {
        return $this->isRoute('statamic.cp.butik.categories.edit');
    }

    private function categoryUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_categories',
            'slug',
            'statamic.cp.butik.categories.update'
        );
    }
}
