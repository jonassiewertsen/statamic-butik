<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Jonassiewertsen\StatamicButik\Http\Models\Order;

class OrderExpired
{
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
