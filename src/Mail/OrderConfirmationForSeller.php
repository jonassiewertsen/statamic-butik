<?php

namespace Jonassiewertsen\StatamicButik\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationForSeller extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;

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
        return $this->view('emails.orders.shipped');
    }
}