<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Tax extends Fieldtype
{
    protected $icon       = 'tags';
    protected $categories = ['butik'];
    protected $selectable = false;

    public function preload()
    {
        return [
            'types' => $this->types(),
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        return $data;
    }

    public function preProcessIndex($data)
    {
        return $data;
    }

    private function types(): array
    {
        return collect(config('butik.tax_types', []))
            ->map(fn ($label, $value) => compact('label', 'value'))
            ->toArray();
    }
}
