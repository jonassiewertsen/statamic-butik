<?php

namespace Jonassiewertsen\StatamicButik\Fieldtypes;

class Tax extends \Statamic\Fields\Fieldtype
{
    protected $icon = 'tags';

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