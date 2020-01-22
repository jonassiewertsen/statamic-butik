<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Mail\Customer\PurchaseConfirmation;

class SendPurchaseConfirmationToCustomer implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        try {
            Mail::queue(new PurchaseConfirmation($event->transaction));
        } catch(\Exception $e) {
            // TODO: Better error handling
            report($e);
        }
    }
}