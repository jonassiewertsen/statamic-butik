<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Statamic\Fields\Fieldtype;
use Symfony\Component\Intl\Countries as CountryProvider;

class Countries extends Fieldtype
{
    protected array $countries;
    protected $categories = ['butik'];
    protected $icon = 'tags';

    public function __construct()
    {
        $this->countries = CountryProvider::getNames(app()->getLocale());
    }

    public function preload()
    {
        return [
            'countries' => $this->mappedCountries(),
        ];
    }

    public function preProcessIndex($data)
    {
        return collect($data)
                ->map(fn ($isoCode) => $this->countries()[$isoCode])
                ->sort()
                ->implode(', ');
    }

    public function process($data)
    {
        return collect($data)
           ->sortBy('label')
           ->map(fn ($item) => $item['value'])
           ->flatten() // To remove the order information from the array
           ->toArray();
    }

    public function preProcess($data)
    {
        return collect($data)
            ->map(function ($isoCode) {
                return [
                    'label' => $this->countries()[$isoCode],
                    'value' => $isoCode,
                ];
            });
    }

    private function countries(): array
    {
        return $this->countries;
    }

    private function mappedCountries(): array
    {
        return collect($this->countries)
            ->flatMap(fn ($label, $value) => [compact('label', 'value')])
            ->toArray();
    }
}
