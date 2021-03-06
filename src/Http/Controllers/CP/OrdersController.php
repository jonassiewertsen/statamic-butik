<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP;

use Jonassiewertsen\Butik\Http\Controllers\CpController;
use Jonassiewertsen\Butik\Http\Models\Order;
use Statamic\Facades\Scope;
use Statamic\Support\Str;

class OrdersController extends CpController
{
    public function index()
    {
        $this->authorize('index', Order::class);

        $filters = Scope::filters('butik', []);

        return view('butik::cp.orders.index', compact('filters'));
    }

    public function show(Order $order)
    {
        $this->authorize('show', $order);

        return view('butik::cp.orders.show', [
            'order' => $order,
            'items' => $order->items,
            'customer' => $order->customer,
            'shippings' => $order->shippings,
            'additionalCustomerInformation' => $this->extractAdditionalInformation($order->customer),
        ]);
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
