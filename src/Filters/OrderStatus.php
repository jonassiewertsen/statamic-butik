<?php

namespace Jonassiewertsen\Butik\Filters;

use Statamic\Query\Scopes\Filter;

class OrderStatus extends Filter
{
    protected $pinned = true;

    public function fieldItems()
    {
        return [
            'order_status' => [
                'type' => 'radio',
                'options' => [
                    'paid' => __('paid'),
                    'failed' => __('failed'),
                    'completed' => __('completed'),
                ],
            ],
        ];
    }

    public function apply($query, $values)
    {
        switch ($values['order_status']) {
            case 'paid':
                $query->where('paid_at', '!=', null);
                break;
            case 'failed':
                $query->where(function ($query) {
                    $query->where('canceled_at', '!=', null)
                    ->orWhere('expired_at', '!=', null);
                });
                break;
            case 'completed':
                $query->where('completed_at', '!=', null);
                break;
        }
    }

    public function badge($values)
    {
        switch ($values['order_status']) {
            case 'paid':
                return __('butik::cp.order_paid_filter_label');
            case 'failed':
                return __('butik::cp.order_failed_filter_label');
            case 'completed':
                return __('butik::cp.order_completed_filter_label');
        }
    }

    public function visibleTo($key)
    {
        return $key === 'butik';
    }
}
