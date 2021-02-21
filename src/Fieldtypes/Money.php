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
        // TODO: Use our Money class for calculations

        // In case we will use another number seperator then '.', like in europe,
        // we will make sure replace to avoid problems calculating with it.
        $data = str_replace(',', '.', $data);

        return number_format(floatval($data), 2, '.', '');
    }

    public function augment($value): array
    {
        return [
            'total' => $value, // {{ price:total }} net or gross. Depends on your config.
            'net' => $value,   // {{ price:net }} // TODO: Calculate the net price
            'gross' => $value,   // {{ price:gross }} // TODO: Calculate the net price
        ];
    }
}
