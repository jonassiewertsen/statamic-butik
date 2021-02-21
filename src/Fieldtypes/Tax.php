<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Http\Models\Tax as TaxModel;
use Statamic\Fields\Fieldtype;

class Tax extends Fieldtype
{
    protected $icon = 'tags';
    protected $categories = ['butik'];
    protected $selectable = false;

    public function preload()
    {
        return [
            'taxes' => $this->fetchTaxOptions(),
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

    public function augment($value): array
    {
        $tax = TaxModel::findOrFail($value);

        return [
            'name' => $tax->title,              // {{ tax:name }}
            'slug' => $value,                   // {{ tax:slug }}
            'amount' => 0,                      // TODO: Calculate the the tax amount
            'percentage' => $tax->percentage,   // {{ tax:percentage }}
        ];
    }

    private function fetchTaxOptions(): array
    {
        return TaxModel::pluck('title', 'slug')->map(function ($key, $value) {
            return [
                'value' => $value,
                'label' => $key,
            ];
        })->toArray();
    }
}
