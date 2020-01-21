<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class CreateOpenOrder implements ShouldQueue
{
    use SerializesModels;

    public function handle()
    {
        Order::create([
                          // TODO: Add the customer into the order
//              'id'           => now()->format('y').'_'.$transaction->id,
              'id'           => 'some fake id',
              'status'       => 'open',
              'products'     => ['something missing'], // TODO: Add the products into the order
              'total_amount' => 4000,
              'paid_at'      => null,

        ]);
    }
}