<?php

namespace Jonassiewertsen\StatamicButik\Filters;

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
                    'shipped' => __('shipped'),
                ],
            ],
        ];
    }

    public function apply($query, $values)
    {
        switch ($values['order_status']) {
            case 'paid':
                return $query->where('paid_at', '!', null);
            case 'failed':
                return $query->where('failed_at', '!', null);
            case 'shipped':
                return $query->where('shipped_at', '!', null);
        }
    }

    public function badge($values)
    {
        switch ($values['order_status']) {
            case 'paid':
                return __('butik::cp.order_paid_filter_label');
            case 'failed':
                return __('butik::cp.order_failed_filter_label');
            case 'shipped':
                return __('butik::cp.order_shipped_filter_label');
        }
    }

    public function visibleTo($key)
    {
        return $key === 'butik';
    }
}
