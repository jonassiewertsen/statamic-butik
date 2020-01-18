<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\PurchaseConfirmationForCustomer;

class SendPurchaseConfirmationToCustomer implements ShouldQueue
{
    use SerializesModels;

    public function handle($transaction)
    {
//        Mail::queue(new PurchaseConfirmationForCustomer());
    }
}