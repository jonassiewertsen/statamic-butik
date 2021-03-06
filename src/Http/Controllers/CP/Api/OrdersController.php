<?php

namespace Jonassiewertsen\Butik\Http\Controllers\CP\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Jonassiewertsen\Butik\Http\Models\Order;
use Jonassiewertsen\Butik\Http\Resources\OrderResource;
use Statamic\Http\Requests\FilteredRequest;
use Statamic\Query\Scopes\Filters\Concerns\QueriesFilters;

class OrdersController
{
    use QueriesFilters;

    /**
     * The requested orders will be returned, respecting any typed search, order or pagination.
     */
    public function index(FilteredRequest $request): OrderResource
    {
        $query = $this->fetchOrders();

        $activeFilterBadges = $this->queryFilters($query, $request->filters);

        $orders = $this->paginatedOrders($query->get());

        return (new OrderResource($orders))
            ->columnPreferenceKey('butik.orders.columns')
            ->additional(['meta' => [
                'activeFilterBadges' => $activeFilterBadges,
            ]]);
    }

    /**
     * Fetching all orders with default ordering and sorting, in case none will be passed.
     * With no search query present, the search will be ignored.
     */
    private function fetchOrders(): Builder
    {
        $sortOrder = request('order') ?? 'desc';
        $sortBy = request('sort') ?? 'created_at';

        if (! request()->filled('search')) {
            return Order::orderBy($sortBy, $sortOrder);
        }

        return $this->searchOrders();
    }

    /**
     * Searching the orders, we will respect all existing customer information. On top
     * of that the following fields are searchable:
     * id, number, status, total amount and the date field.
     */
    private function searchOrders(): Builder
    {
        $search = request('search');
        $searchTerm = "%{$search}%";

        return Order::where(function ($query) use ($searchTerm) {
            $query->where('customer', 'like', $searchTerm)
                ->orWhere('id', 'like', $searchTerm)
                ->orWhere('number', 'like', $searchTerm)
                ->orWhere('status', 'like', $searchTerm)
                ->orWhere('total_amount', 'like', $searchTerm)
                ->orWhere('created_at', 'like', $searchTerm);
        });
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
