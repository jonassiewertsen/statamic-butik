<?php

namespace Jonassiewertsen\StatamicButik\Mail\Seller;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;

class OrderConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject(__('butik::order.new_purchase'))
            ->view('butik::email.orders.orderConfirmationToSeller')
            ->with([
               'id'             => $this->transaction->id,
               'totalAmount'    => $this->transaction->totalAmount,
               'currencySymbol' => $this->transaction->currencySymbol,
               'paidAt'         => $this->transaction->paidAt,
               'items'          => $this->transaction->items,
           ]);
    }
}
