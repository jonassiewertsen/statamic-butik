<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Exceptions\PurchaseConfirmationToCustomerNotSent;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Mail\Customer\PurchaseConfirmation;

class SendPurchaseConfirmationToCustomer implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        try {
            Mail::to($event->transaction->customer->mail)
                ->queue(new PurchaseConfirmation($event->transaction));
        } catch(\Exception $e) {
            throw new PurchaseConfirmationToCustomerNotSent();
        }
    }
}