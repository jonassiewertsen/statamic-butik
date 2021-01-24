<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Mail\Seller\OrderConfirmation;

class SendPurchaseConfirmationToSeller implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        try {
            Mail::to(config('butik.order-confirmations'))
                ->queue(new OrderConfirmation($event->order));
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }
}
