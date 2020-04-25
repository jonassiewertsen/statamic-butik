<?php

namespace Jonassiewertsen\StatamicButik\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;

class PurchaseConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject(__('butik::order.confirmation'))
            ->view('butik::email.orders.purchaseConfirmationForCustomer')
            ->with([
                'id'             => $this->transaction->id,
                'totalAmount'    => $this->transaction->totalAmount,
                'paidAt'         => $this->transaction->paidAt,
                'items'          => $this->transaction->items,
            ]);

    }
}
