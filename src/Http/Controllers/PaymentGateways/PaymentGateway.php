<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\PaymentGateways;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Checkout\Customer;
use Jonassiewertsen\StatamicButik\Events\OrderAuthorized;
use Jonassiewertsen\StatamicButik\Events\OrderCanceled;
use Jonassiewertsen\StatamicButik\Events\OrderCompleted;
use Jonassiewertsen\StatamicButik\Events\OrderCreated;
use Jonassiewertsen\StatamicButik\Events\OrderExpired;
use Jonassiewertsen\StatamicButik\Events\OrderPaid;
use Jonassiewertsen\StatamicButik\Http\Controllers\WebController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Order\ItemCollection;

abstract class PaymentGateway extends WebController
{
    protected function isPaid(Order $order, Carbon $paidAt = null)
    {
        $order->update([
            'status'    => 'paid',
            'paid_at'  => $paidAt ?? now(),
        ]);

        event(new OrderPaid($order));
    }

    protected function isAuthorized(Order $order, Carbon $authorizedAt = null)
    {
        $order->update([
            'status'        => 'authorized',
            'authorized_at' => $authorizedAt ?? now(),
        ]);

        event(new OrderAuthorized($order));
    }

    protected function isCompleted(Order $order, Carbon $completedAt = null)
    {
        $order->update([
            'status'       => 'completed',
            'completed_at' => $completedAt ?? now(),
        ]);

        event(new OrderCompleted($order));
    }

    protected function isExpired(Order $order, Carbon $expiredAt = null)
    {
        $order->update([
            'status'     => 'expired',
            'expired_at' => $expiredAt ?? now(),
        ]);

        event(new OrderExpired($order));
    }

    protected function isCanceled(Order $order, Carbon $canceledAt = null)
    {
        $order->update([
            'status'        => 'canceled',
            'canceled_at' => $canceledAt ?? now(),
        ]);

        event(new OrderCanceled($order));
    }

    protected function createOrder(string $id, Collection $items, Customer $customer, string $totalPrice, ?string $method): Order
    {
        $order = Order::create([
            'id'           => $id,
            'status'       => 'created',
            'customer'     => $customer,
            'total_amount' => $totalPrice,
            'number'       => $this->createOrderNumber(),
            'items'        => new ItemCollection($items),
        ]);

        event(new OrderCreated($order));

        return $order;
    }

    protected function findOrder(string $orderNumber): ?Order
    {
        return Order::whereNumber($orderNumber)->firstOrFail();
    }

    protected function createOrderNumber(): string
    {
        return now()->format('Ymd_') . str_random(30);
    }
}
