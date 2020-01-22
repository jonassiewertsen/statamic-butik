<?php

namespace Jonassiewertsen\StatamicButik\Mail\Customer;

use Braintree\Collection;
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
        // TODO: test for to and from !
        return $this->to('test@mail.com')
            ->from('butik@butik.com')
            ->view('statamic-butik::email.orders.purchaseConfirmationForCustomer')
            ->with([
                'id'             => $this->transaction->id,
                'totalAmount'    => $this->transaction->totalAmount,
                'currencySymbol' => $this->transaction->currencySymbol,
                'paidAt'         => $this->transaction->paidAt,
                'products'       => $this->transaction->products,
            ]);

    }
}