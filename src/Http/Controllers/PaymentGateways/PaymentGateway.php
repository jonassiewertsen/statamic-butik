<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Jonassiewertsen\StatamicButik\Events\PaymentSuccessful;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;

abstract class PaymentGateway extends WebController
{
    protected function isPaid($payment)
    {
        $this->updateOrderStatus($payment);
        event(new PaymentSuccessful($payment));
    }

    protected function isAuthorized($payment)
    {
        $this->updateOrderStatus($payment);
        // TODO: Fire authorized event
    }

    protected function isCompleted($payment)
    {
        $this->updateOrderStatus($payment);
        // TODO: Fire completed event
    }

    protected function isExpired($payment)
    {
        $this->updateOrderStatus($payment);
        // TODO: Fire expired event
    }

    protected function isCanceled($payment)
    {
        $this->updateOrderStatus($payment);
        // TODO: Fire canceled event
    }

    private function updateOrderStatus($payment): void
    {
        $order = Order::whereNumber($payment->id)->firstOrFail();
        $timestamp = $payment->status . '_at';
        $order->update([
            'status'    => $payment->status,
            'method'    => $payment->method,
            $timestamp  => now(),
        ]);
    }
}
