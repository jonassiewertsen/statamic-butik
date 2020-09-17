<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Number extends Fieldtype
{
    protected $icon       = 'integer';
    protected $categories = ['butik', 'text'];

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        // In case another dec point then '.' has been just, we will reformat
        $data = str_replace(',', '.', $data);

        return number_format(floatval($data), 2, '.', '');
    }
}
