<?php

namespace Jonassiewertsen\StatamicButik\Events;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Transaction;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

class PaymentSuccessful
{
    use SerializesModels;

    public $transaction;

    public function __construct($payment)
    {
        $this->transaction = (new Transaction())
            ->id($payment->id)
            ->method($payment->method)
            ->products($this->fetchProducts($payment))
            ->totalAmount($payment->amount->value)
            ->createdAt(Carbon::parse($payment->createdAt))
            ->paidAt(Carbon::parse($payment->paidAt));
    }

    private function fetchProducts($payment): Collection {
        $order = Order::whereId($payment->id)->firstOrFail();
        return collect($order->products);
    }
}