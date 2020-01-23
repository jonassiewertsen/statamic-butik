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
        return $this->subject(__('statamic-butik::order.new_purchase'))
            ->view('statamic-butik::email.orders.orderConfirmationToSeller')
            ->with([
               'id'             => $this->transaction->id,
               'totalAmount'    => $this->transaction->totalAmount,
               'currencySymbol' => $this->transaction->currencySymbol,
               'paidAt'         => $this->transaction->paidAt,
               'products'       => $this->transaction->products,
           ]);
    }
}