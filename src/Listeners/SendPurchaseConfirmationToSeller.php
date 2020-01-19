<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\OrderConfirmationForSeller;

class SendPurchaseConfirmationToSeller implements ShouldQueue
{
    use SerializesModels;

    public function handle($transaction)
    {
        // Removing the transaction wrapper
        $transaction = $transaction->transaction;

        try {
            // TODO: Seems not to work jet ...
            Mail::queue(new OrderConfirmationForSeller($transaction));
        } catch (\Exception $e) {
            report($e);
        }
    }
}