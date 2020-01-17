<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class CreateOrder implements ShouldQueue
{
    use SerializesModels;

    public function handle($transaction)
    {
        // Getting the transaction data from inside the nested object
        $transaction = $transaction->transaction;

        Order::create([
              'id'           => now()->format('y').'_'.$transaction->id,
              'products'     => ['something missing'], // TODO: Add the products into the order
              'total_amount' => $transaction->amount,
              'paid_at'      => $transaction->createdAt, // TODO: Add the customer into the order
        ]);
    }
}