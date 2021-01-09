<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Resources\OrderResource;

class OrdersController
{
    public function index()
    {
        $orders = Order::all();

        $paginator = new LengthAwarePaginator($orders, 2, 50, 0);

        return (new OrderResource($paginator))
            ->columnPreferenceKey("id");
    }
}
