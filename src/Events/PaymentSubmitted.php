<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;

class PaymentSubmitted
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct($payment, Cart $cart, string $orderId)
    {
        $this->transaction = (new Transaction())
            ->id($orderId)
            ->transactionId($payment->id)
            ->method($payment->method ?? '') // TODO: Only a problem with multiple payment options
            ->totalAmount($payment->amount->value)
            ->createdAt(Carbon::parse($payment->createdAt))
            ->products($cart->items)
            ->customer($cart->customer);
    }
}
