<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class OrderCreated
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
