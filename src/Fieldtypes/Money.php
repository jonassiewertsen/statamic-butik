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
        ];
    }

    public function process($data)
    {
        return $data;
    }

    public function preProcess($data)
    {
        // In case we will use another number seperator then '.', like in europe,
        // we will make sure replace to avoid problems calculating with it.
        $data = str_replace(',', '.', $data);

        return number_format(floatval($data), 2, '.', '');
    }
}
