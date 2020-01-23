<?php

namespace Jonassiewertsen\StatamicButik\Widgets;

use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\CP\Column;
use Statamic\Facades\User;
use Statamic\Widgets\Widget;

class Orders extends Widget {
    public function html() {
        if (! User::current()->can('view orders')) {
            return;
        }

        $orders = Order::select('id', 'status', 'total_amount', 'method', 'customer', 'created_at')
            ->orderByDesc('created_at')
            ->limit(config('statamic-butik.widgets.orders.limit', '10'))
            ->get()
            ->map(function ($order) {
                return [
                    'id'           => $order->id,
                    'customer'     => json_decode($order->customer)->name,
                    'mail'         => json_decode($order->customer)->mail,
                    'status'       => $order->status,
                    'method'       => $order->method,
                    'total_amount' => $order->total_amount,
                    'created_at'   => $order->created_at->format('d-m-Y H:i'),
                ];
            });

        return view('statamic-butik::widgets.orders', compact('orders'));
    }
}