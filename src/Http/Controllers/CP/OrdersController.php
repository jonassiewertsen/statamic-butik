<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP;

use Jonassiewertsen\StatamicButik\Http\Controllers\CpController;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Support\Str;

class OrdersController extends CpController
{
    public function index()
    {
        $this->authorize('index', Order::class);

        return view('butik::cp.orders.index');
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
