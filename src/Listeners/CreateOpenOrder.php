<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Events\PaymentSubmitted;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class CreateOpenOrder implements ShouldQueue
{
    use SerializesModels;

    public function handle(PaymentSubmitted $event)
    {
        Order::create([
            'id'             => $event->transaction->id,
            'transaction_id' => $event->transaction->transactionId,
            'status'         => 'open',
            'method'         => $event->transaction->method,
            'items'          => $event->transaction->items,
            'customer'       => json_encode($event->transaction->customer),
            'total_amount'   => $event->transaction->totalAmount,
            'paid_at'        => null,
            'created_at'     => $event->transaction->createdAt,
        ]);
    }
}
