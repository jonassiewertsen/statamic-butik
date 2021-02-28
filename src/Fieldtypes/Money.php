<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Money extends Fieldtype
{
    protected $categories = ['butik'];
    protected $selectable = false;
    protected $icon = 'tags';

    public function preload()
    {
        return [
            'currencySymbol' => currency(),
            'priceDefault' => config('butik.price', 'gross'),
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        // TODO: Use our Price Facade for calculations

        // In case we will use another number seperator then '.', like in europe,
        // we will make sure replace to avoid problems calculating with it.
        $data = str_replace(',', '.', $data);

        return number_format(floatval($data), 2, '.', '');
    }

    public function augment($value): array
    {
        return [
            'gross' => $this->calculateGross($value), // {{ price:gross }}
            'net' => $this->calculateNet($value),     // {{ price:net }}
            'total' => $value,                        // {{ price:total }}
        ];
    }

    private function calculateNet($value)
    {
        if ($this->preload()['priceDefault'] === 'net') {
            return $value;
        }

        return $value;
    }

    private function calculateGross($value)
    {
        if ($this->preload()['priceDefault'] === 'gross') {
            return $value;
        }

        return $value;
    }
}
