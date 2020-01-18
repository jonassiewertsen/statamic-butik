<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Illuminate\Queue\SerializesModels;

class PaymentSuccessful
{
    use SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param  $transaction
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }
}