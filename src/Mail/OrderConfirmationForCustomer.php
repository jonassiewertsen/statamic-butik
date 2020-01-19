<?php

namespace Jonassiewertsen\StatamicButik\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationForCustomer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($transaction)
    {
        $this->transaction = [
            'id'         => $transaction->id,
            'amount'     => $transaction->amount,
            'currency'   => $transaction->currencyIsoCode,
            'created_at' => $transaction->createdAt,
        ];
    }

    public function build()
    {
        // TODO: make customizable
        return $this->view('statamic-butik::email.orders.customerConfirmation');
    }
}