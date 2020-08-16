<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Jonassiewertsen\StatamicButik\Http\Models\Order;

class PaymentSuccessful
{
    public $order;

    public function __construct($payment)
    {
        // TODO: It would be even more clean, if passing the order directly
        $this->order = Order::whereNumber($payment->id)->firstOrFail();
    }
}
