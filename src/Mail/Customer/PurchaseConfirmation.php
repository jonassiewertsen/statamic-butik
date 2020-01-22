<?php

namespace Jonassiewertsen\StatamicButik\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Statamic\Tags\Trans;

class PurchaseConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        // TODO: make customizable
        return $this->view('statamic-butik::email.orders.customerConfirmation');
    }
}