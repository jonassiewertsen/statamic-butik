<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Mollie\Api\Resources\Payment;

class PaymentSubmitted
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct($payment, Cart $cart)
    {
        $this->transaction = (new Transaction())
            ->id($payment->id)
            ->method($payment->method)
            ->totalAmount($payment->amount->value)
            ->createdAt(Carbon::parse($payment->createdAt))
            ->products($cart->products)
            ->customer($cart->customer);
    }
}