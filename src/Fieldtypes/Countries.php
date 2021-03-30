<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Symfony\Component\Intl\Countries as CountryProvider;

class Countries extends Fieldtype
{
    protected $categories = ['butik'];
    protected $icon = 'tags';

    public function preload()
    {
        $countries = CountryProvider::getNames(app()->getLocale()); // TODO: Refactor to Facade
        $options = [];

        foreach ($countries as $value => $label) {
            $options[] = [
              'label' => $label,
              'value' => $value,
            ];
        }

        return [
            'countries' => $options,
        ];
    }

    public function preProcessIndex($data)
    {
        return collect($data)
                ->sortBy('label')
                ->flatMap(fn($country) => [$country['label']])
                ->implode(', ');
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        return $data;
    }
}
