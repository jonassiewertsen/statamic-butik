<?php

namespace Jonassiewertsen\Butik\Events;

use Jonassiewertsen\Butik\Http\Models\Order;

class OrderCanceled
{
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
