<?php

namespace Jonassiewertsen\StatamicButik\Blueprints;

use Statamic\Facades\Blueprint as StatamicBlueprint;

class CountryBlueprint extends Blueprint
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
                                'display'  => __('butik::general.title'),
                                'validate' => 'required',
                            ],
                        ],
                        [
                            'handle' => 'iso',
                            'field'  => [
                                'type'     => 'text',
                                'display'  => __('butik::country.iso'),
                                'width'    => '33',
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
                                'type'      => 'slug',
                                'display'   => __('butik::general.slug'),
                                'validate'  => ['required', $this->countryUniqueRule()],
                                'read_only' => $this->slugReadOnly(),
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
    private function slugReadOnly(): bool
    {
        return $this->isRoute('statamic.cp.butik.countries.edit');
    }

    private function countryUniqueRule()
    {
        return $this->ignoreUnqiueOn(
            'butik_countries',
            'slug',
            'statamic.cp.butik.countries.update'
        );
    }
}
