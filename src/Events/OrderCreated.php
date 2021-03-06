<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class OrderCreated
{
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
