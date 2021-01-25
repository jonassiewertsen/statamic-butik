<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Order;
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
