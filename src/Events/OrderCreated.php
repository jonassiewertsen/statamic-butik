<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Auth\User;

class OrderCreated
{
    use SerializesModels;

    public Order $order;
    public ?User $loggedInUser;

    public function __construct(Order $order, ?User $loggedInUser = null)
    {
        $this->order = $order;
        $this->loggedInUser = $loggedInUser;
    }
}
