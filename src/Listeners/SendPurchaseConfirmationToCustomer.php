<?php

namespace Jonassiewertsen\Butik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\Butik\Mail\Customer\PurchaseConfirmation;

class SendPurchaseConfirmationToCustomer implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        try {
            Mail::to($event->order->customer->email)
                ->queue(new PurchaseConfirmation($event->order));
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }
}
