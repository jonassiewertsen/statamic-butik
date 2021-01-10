@extends('statamic::layout')
@section('title', __('butik::cp.order_overview'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::cp.order_overview') }}</h1>
    </div>

    <butik-order-list
{{--            run-action-url="{{ cp_route('', $order) }}"--}}
{{--            bulk-actions-url="{{ cp_route('', $order)) }}"--}}
        initial-sort-column="date"
        initial-sort-direction="desc"
        v-cloak
    >
        <div slot="no-results" class="card">
            {{ __('butik::cp.no_orders_yet') }}
        </div>
    </butik-order-list>

@endsection
