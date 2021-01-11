<?php

namespace Jonassiewertsen\StatamicButik\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;
use Jonassiewertsen\StatamicButik\Blueprints\OrderBlueprint;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Facades\User;
use Statamic\Http\Resources\CP\Concerns\HasRequestedColumns;

class OrderResource extends ResourceCollection
{
    use HasRequestedColumns;

    public $collects = Order::class;
    protected $blueprint;
    protected $columns;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $orderBlueprint = new OrderBlueprint();
        $this->blueprint = $orderBlueprint();
    }

    public function columnPreferenceKey($key)
    {
        $this->columnPreferenceKey = $key;

        return $this;
    }

    public function toArray($request)
    {
        $this->setColumns();

        return [
            'data' => $this->collection->transform(function ($order) {
                $customer = $order->customer;

                return [
                    'id'           => $order->id,
                    'number'       => $order->number,
                    'status'       => $order->status,
                    'method'       => $order->method,
                    'items_count'  => collect($order->items)->count(),
                    'name'         => $customer->firstname.' '.$customer->surname,
                    'email'        => $customer->email,
                    'total_amount' => $order->total_amount,
                    'created_at'   => $this->formatDate($order->created_at),
                    'paid_at'      => $this->formatDate($order->paid_at),
                    'failed_at'    => $this->formatDate($order->failed_at),
                    'canceled_at'    => $this->formatDate($order->canceled_at),
                    'shipped_at'   => $this->formatDate($order->shipped_at),
                    'completed_at'   => $this->formatDate($order->completed_at),

                    'viewable' => User::current()->can('view orders', $order),
                    'editable' => User::current()->can('update orders', $order),
                ];
            }),

            'meta' => [
                'columns' => $this->visibleColumns(),
            ],
        ];
    }

    private function setColumns()
    {
        $columns = $this->blueprint->columns();

        if ($key = $this->columnPreferenceKey) {
            $columns->setPreferred($key);
        }

        $this->columns = $columns->rejectUnlisted()->values();
    }

    private function formatDate(?Carbon $date): ?string
    {
        $format = config('statamic.cp.date_format').' H:i';

        if (! $date) {
            return null;
        }

        return $date->format($format);
    }
}
