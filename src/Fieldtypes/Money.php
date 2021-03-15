<?php

namespace Jonassiewertsen\Butik\Fieldtypes;

use Jonassiewertsen\Butik\Facades\Price;
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
        return Price::of($data)->delimiter('.')->thousands('')->get();
    }

    public function augment($value): array
    {
        return [
            'gross' => $this->calculateGross($value), // {{ price:gross }}
            'net' => $this->calculateNet($value),     // {{ price:net }}
            'total' => Price::of($value)->get(),      // {{ price:total }}
        ];
    }

    private function calculateNet($value)
    {
        return Price::of($value)->get();

//        TODO: Add net to price fieldset
//        if ($this->preload()['priceDefault'] === 'net') {
//            return $value;
//        }
//
//        return $value;
    }

    private function calculateGross($value)
    {
        return Price::of($value)->get();

//        TODO: Add gross to price fieldset
//        if ($this->preload()['priceDefault'] === 'gross') {
//            return $value;
//        }
//
//        return $value;
    }
}
