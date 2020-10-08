<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Jonassiewertsen\StatamicButik\Shipping\Country;
use Statamic\Fields\Fieldtype;

class Countries extends Fieldtype
{
    protected $categories = ['butik'];
    protected $icon       = 'tags';

    public function preload()
    {
        return [
            'countries' => Country::list(),
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
}
