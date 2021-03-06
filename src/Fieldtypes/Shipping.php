<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Jonassiewertsen\Butik\Http\Models\ShippingProfile;
use Statamic\Fields\Fieldtype;

class Shipping extends Fieldtype
{
    protected $icon = 'tags';
    protected $categories = ['butik'];
    protected $selectable = false;

    public function preload()
    {
        return [
            'shippings' => $this->fetchShippingOptions(),
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

    private function fetchShippingOptions(): array
    {
        return ShippingProfile::pluck('title', 'slug')->map(function ($key, $value) {
            return [
                'value' => $value,
                'label' => $key,
            ];
        })->toArray();
    }
}
