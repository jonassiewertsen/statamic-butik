<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Blueprints\ProductBlueprint;
use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\CP\Column;

class OrdersController extends CpController
{
    public function index() {
        $this->authorize('index', Order::class);

        $orders = Order::select('id', 'status', 'total_amount', 'method', 'customer', 'created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'id'           => $order->id,
                    'customer'     => json_decode($order->customer)->name,
                    'mail'         => json_decode($order->customer)->mail,
                    'status'       => $order->status,
                    'method'       => $order->method,
                    'total_amount' => $order->total_amount,
                    'show_url'     => $order->show_url,
                    'created_at'   => $order->created_at->format('d-m-Y H:i'),
                    'deleteable'   => false,
                ];
            })->sortByDesc('created_at')->values();

        return view('statamic-butik::cp.orders.index', [
            'orders' => $orders,
            'columns' => [
                Column::make('id')->label(__('statamic-butik::order.id')),
                Column::make('status')->label(__('statamic-butik::order.status')),
                Column::make('customer')->label(__('statamic-butik::order.customer')),
                Column::make('mail')->label(__('statamic-butik::order.mail')),
                Column::make('method')->label(__('statamic-butik::order.method')),
                Column::make('total_amount')->label(__('statamic-butik::order.total_amount')),
                Column::make('created_at')->label(__('statamic-butik::order.created_at')),
            ],
        ]);
    }

    public function show(Order $order) {
        $this->authorize('show', Order::class);

        $customer = json_decode($order->customer);
        $products = $order->products;

        return view('statamic-butik::cp.orders.show', compact('order', 'customer', 'products'));
    }
}
