<?php

namespace Jonassiewertsen\Butik\Http\Controllers\PaymentGateways;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Jonassiewertsen\Butik\Cart\Customer;
use Jonassiewertsen\Butik\Events\OrderAuthorized;
use Jonassiewertsen\Butik\Events\OrderCanceled;
use Jonassiewertsen\Butik\Events\OrderCompleted;
use Jonassiewertsen\Butik\Events\OrderCreated;
use Jonassiewertsen\Butik\Events\OrderExpired;
use Jonassiewertsen\Butik\Events\OrderPaid;
use Jonassiewertsen\Butik\Http\Controllers\WebController;
use Jonassiewertsen\Butik\Http\Models\Order;
use Jonassiewertsen\Butik\Order\ItemCollection;

abstract class PaymentGateway extends WebController
{
    /**
     * Update the order, if it has been paid and fire the belonging event.
     */
    protected function isPaid(Order $order, ?Carbon $paidAt = null, ?string $method = null)
    {
        $order->update([
            'status'    => 'paid',
            'method'    => $method,
            'paid_at'   => $paidAt ?? now(),
        ]);

        event(new OrderPaid($order));
    }

    /**
     * Update the order, if it has been authorized and fire the belonging event.
     */
    protected function isAuthorized(Order $order, ?Carbon $authorizedAt = null, ?string $method = null)
    {
        $order->update([
            'status'        => 'authorized',
            'method'        => $method,
            'authorized_at' => $authorizedAt ?? now(),
        ]);

        event(new OrderAuthorized($order));
    }

    /**
     * Update the order, if it has been completed and fire the belonging event.
     */
    protected function isCompleted(Order $order, ?Carbon $completedAt = null, ?string $method = null)
    {
        $order->update([
            'status'       => 'completed',
            'method'       => $method,
            'completed_at' => $completedAt ?? now(),
        ]);

        event(new OrderCompleted($order));
    }

    /**
     * Update the order, if it has been expired and fire the belonging event.
     */
    protected function isExpired(Order $order, ?Carbon $expiredAt = null)
    {
        $order->update([
            'status'     => 'expired',
            'expired_at' => $expiredAt ?? now(),
        ]);

        event(new OrderExpired($order));
    }

    /**
     * Update the order, if it has been canceled and fire the belonging event.
     */
    protected function isCanceled(Order $order, ?Carbon $canceledAt = null)
    {
        $order->update([
            'status'        => 'canceled',
            'canceled_at' => $canceledAt ?? now(),
        ]);

        event(new OrderCanceled($order));
    }

    /**
     * Create the order in our database.
     */
    protected function createOrder(string $id, Collection $items, string $orderNumber, Customer $customer, string $totalPrice, ?string $method = null, ?Collection $shippings = null): Order
    {
        $order = Order::create([
            'id'           => $id,
            'method'       => $method,
            'status'       => 'created',
            'customer'     => $customer,
            'total_amount' => $totalPrice,
            'number'       => $orderNumber,
            'items'        => (new ItemCollection($items))->items,
            'shippings'    => $shippings ? json_encode($shippings->toArray()) : collect(), // TODO: Require shippings with the next major release.
        ]);

        event(new OrderCreated($order));

        return $order;
    }

    /**
     * Fetching a order belonging to the order number.
     */
    protected function findOrder(string $orderId): ?Order
    {
        return Order::whereId($orderId)->firstOrFail();
    }

    /**
     * Create an order number.
     */
    protected function createOrderNumber(): string
    {
        return now()->format('Ymd_').str_random(30);
    }
}
