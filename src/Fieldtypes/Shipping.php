<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Http\Models\ShippingProfile;
use Statamic\Fields\Fieldtype;

class Shipping extends Fieldtype
{
    protected $icon = 'tags';

    public function preload() {
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

    private function fetchShippingOptions(): array {
         return ShippingProfile::pluck('title', 'slug')->map(function($key, $value) {
             return [
                 'value' => $value,
                 'label' => $key,
             ];
         })->toArray();
    }
}
