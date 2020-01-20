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
}