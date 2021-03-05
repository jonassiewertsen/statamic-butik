<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Resources\OrderResource;
use Statamic\Http\Controllers\CP\ActionController;

class OrderActionController extends ActionController
{
    protected function getSelectedItems($items, $context)
    {
        return Order::find($items);
    }
}
