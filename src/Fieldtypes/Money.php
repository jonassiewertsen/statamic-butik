<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

class Money extends \Statamic\Fields\Fieldtype
{
    protected $icon = 'tags';

    public function preload() {
        return [
            'currencySymbol' => config('statamic-butik.currency.symbol', ''),
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        // In case another dec point then '.' has been just, we will reformat
        return number_format(floatval($data), 2, '.', '');
    }
}