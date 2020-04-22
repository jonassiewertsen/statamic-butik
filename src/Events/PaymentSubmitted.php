<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Cart;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;

class PaymentSubmitted
{
    use SerializesModels;

    public Transaction $transaction;

    public function __construct($payment, Customer $customer, Collection $items, string $orderId)
    {
        $this->transaction = (new Transaction())
            ->id($orderId)
            ->transactionId($payment->id)
            ->method($payment->method ?? '')
            ->totalAmount($payment->amount->value)
            ->createdAt(Carbon::parse($payment->createdAt))
            ->items($items)
            ->customer($customer);
    }
}
