<?php

namespace Jonassiewertsen\StatamicButik\Http\Controllers\CP\Api;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Jonassiewertsen\StatamicButik\Http\Resources\OrderResource;

class OrdersController
{
    /**
     * The requested orders will be returned, respecting any typed search, order or pagination.
     */
    public function index(): OrderResource
    {
        $orders = $this->paginatedOrders(
            $this->fetchOrders()
        );

        return (new OrderResource($orders))
            ->columnPreferenceKey("created_at");
    }

    /**
     * Fetching all orders with default ordering and sorting, in case none will be passed.
     * With no search query present, the search will be ignored.
     */
    private function fetchOrders(): Collection
    {
        $sortOrder = request('order') ?? 'desc';
        $sortBy = request('sort') ?? 'created_at';

        if (! request()->filled('search')) {
            return Order::orderBy($sortBy, $sortOrder)->get();
        }

        return $this->searchOrders();
    }

    /**
     * Searching the orders, we will respect all existing customer information. On top
     * of that the following fields are searchable:
     * id, number, status, total amount and the date field.
     */
    private function searchOrders(): Collection
    {
        $search = request('search');
        $searchTerm = "%{$search}%";

        return Order::where('customer', 'like', $searchTerm)
            ->orWhere('id', 'like', $searchTerm)
            ->orWhere('number', 'like', $searchTerm)
            ->orWhere('status', 'like', $searchTerm)
            ->orWhere('total_amount', 'like', $searchTerm)
            ->orWhere('created_at', 'like', $searchTerm)
            ->get();
    }

    /**
     * Paginating the orders to only return those, which are within the
     * range the user wants displayed.
     */
    private function paginatedOrders($orders): LengthAwarePaginator
    {
        $perPage = request('perPage') ?? config('statamic.cp.pagination_size');
        $currentPage = (int) request('page') ?? 0;
        $offset = ($currentPage - 1) * $perPage;
        $totalCount = $orders->count();

        $orders = $orders->slice($offset, $perPage);

        return new LengthAwarePaginator($orders, $totalCount, $perPage, $currentPage);
    }
}
