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
        // TODO: Make more clear what to do with this mails. Ship itens etc ...
        // TODO: make customizable
        return $this->to('test@mail.com')
            ->from('butik@butik.com')
            ->view('statamic-butik::email.orders.orderConfirmationToSeller')
            ->with([
               'id'             => $this->transaction->id,
               'totalAmount'    => $this->transaction->totalAmount,
               'currencySymbol' => $this->transaction->totalAmount,
               'paidAt'         => $this->transaction->paidAt,
               'products'       => $this->transaction->products,
           ]);
    }
}