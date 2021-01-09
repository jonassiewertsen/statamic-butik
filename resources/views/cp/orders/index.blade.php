@extends('statamic::layout')
@section('title', __('butik::cp.order_overview'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::cp.order_overview') }}</h1>
    </div>

    @unless($orders->isEmpty())

        <butik-order-list
            :initial-rows="{{ json_encode($orders) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-order-list>

    @else

        <div class="card">
            {{ __('butik::cp.no_orders_yet') }}
        </div>

    @endunless

@endsection
