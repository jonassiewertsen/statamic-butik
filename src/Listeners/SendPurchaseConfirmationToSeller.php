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
        try {
            Mail::queue(new OrderConfirmationForSeller());
        } catch (\Exception $e) {
            // TODO: Do something
        }
    }
}