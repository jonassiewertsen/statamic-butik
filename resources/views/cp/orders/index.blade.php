@extends('statamic::layout')
@section('title', __('butik::cp.order_overview'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::cp.order_overview') }}</h1>
    </div>

    <butik-order-list
        show-route="{{ cp_route('butik.orders.show', 'XXX') }}"
        orders-request-url="{{ cp_route('butik.api.orders.index') }}"
        run-action-url="{{ cp_route('butik.actions.orders.run') }}"
        bulk-actions-url="{{ cp_route('butik.actions.orders.bulk') }}"
        :filters="{{ json_encode($filters) }}"
        v-cloak
    >
        <div slot="no-results" class="card">
            {{ __('butik::cp.no_orders_yet') }}
        </div>
    </butik-order-list>

@endsection
