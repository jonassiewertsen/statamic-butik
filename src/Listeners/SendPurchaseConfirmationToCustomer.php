<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\OrderConfirmationForCustomer;

class SendPurchaseConfirmationToCustomer implements ShouldQueue
{
    use SerializesModels;

    public function handle($transaction)
    {
        // Removing the transaction wrapper
        $transaction = $transaction->transaction;

        try {
            // TODO: Seems not to send mails now
            Mail::queue(new OrderConfirmationForCustomer($transaction));
        } catch(\Exception $e) {
            report($e);
        }
    }
}