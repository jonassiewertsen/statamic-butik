<?php

namespace Jonassiewertsen\Butik\Events;

use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\Butik\Http\Models\Order;

class OrderCreated
{
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
