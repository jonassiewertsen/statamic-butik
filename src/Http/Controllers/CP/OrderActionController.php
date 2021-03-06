<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Jonassiewertsen\Butik\Http\Models\Order;
use Statamic\Http\Controllers\CP\ActionController;

class OrderActionController extends ActionController
{
    protected function getSelectedItems($items, $context)
    {
        return $items->map(function ($item) {
            return Order::find($item);
        });
    }
}
