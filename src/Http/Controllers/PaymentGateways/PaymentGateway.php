<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Carbon\Carbon;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

abstract class PaymentGateway extends WebController
{
    protected function setOrderStatusToPaid($payment): void
    {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
            'status'  => 'paid',
            'method'  => $payment->method,
            'paid_at' => Carbon::parse($payment->paidAt),
        ]);
    }

    protected function setOrderStatusToFailed($payment): void
    {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
            'status'    => 'failed',
            'method'    => $payment->method,
            'failed_at' => Carbon::parse($payment->failedAt),
        ]);
    }

    protected function setOrderStatusToExpired($payment): void
    {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
            'method' => $payment->method,
            'status' => 'expired',
        ]);
    }

    protected function setOrderStatusToCanceled($payment): void
    {
        $order = Order::whereTransactionId($payment->id)->firstOrFail();
        $order->update([
            'method' => $payment->method,
            'status' => 'canceled',
        ]);
    }
}
