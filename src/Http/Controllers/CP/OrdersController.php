<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\CP\Column;
use Statamic\Support\Str;

class OrdersController extends CpController
{
    public function index()
    {
        $this->authorize('index', Order::class);

        $orders = Order::select('id', 'status', 'total_amount', 'method', 'customer', 'created_at')
            ->get()
            ->map(function ($order) {
                return [
                    'id'           => $order->id,
                    'customer'     => $order->customer->firstname.' '.$order->customer->surname,
                    'email'        => $order->customer->email,
                    'status'       => $order->status,
                    'method'       => $order->method,
                    'total_amount' => $order->total_amount,
                    'show_url'     => $order->show_url,
                    'created_at'   => $order->created_at->format('d-m-Y H:i'),
                    'deleteable'   => false,
                ];
            })->sortByDesc('created_at')->values();

        return view('butik::cp.orders.index', [
            'orders'  => $orders,
            'columns' => [
                Column::make('id')->label(__('butik::cp.id')),
                Column::make('status')->label(__('butik::cp.status')),
                Column::make('customer')->label(__('butik::cp.customer')),
                Column::make('email')->label(__('butik::cp.email')),
                Column::make('method')->label(__('butik::cp.method')),
                Column::make('total_amount')->label(__('butik::cp.total_amount')),
                Column::make('created_at')->label(__('butik::cp.created_at')),
            ],
        ]);
    }

    public function show(Order $order)
    {
        $this->authorize('show', $order);

        $customer = $order->customer;
        $additionalCustomerInformation = $this->extractAdditionalInformation($customer);
        $items = $order->items;

        return view('butik::cp.orders.show', compact('order', 'customer', 'additionalCustomerInformation', 'items'));
    }

    /**
     * We will only return those values, which aren't default values.
     */
    private function extractAdditionalInformation(\stdClass $customer)
    {
        $defaultValues = ['firstname', 'surname', 'email', 'address1', 'address2', 'city', 'zip', 'country'];

        return collect($customer)->filter(function ($value, $key) use ($defaultValues) {
            // Filtering if additinal values do exist.
            return ! in_array($key, $defaultValues);
        })->map(function ($value, $key) {
            // Returning additional values with a converted name.
            // tax_id will become to Tax Id
            return [
                'name'  => (string) Str::of($key)->replace('_', ' ')->title(),
                'value' => $value,
            ];
        });
    }
}
