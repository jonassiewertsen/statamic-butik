@extends('statamic::layout')
@section('title', __('butik::product.index'))

@section('content')

    <div class="flex mb-3">
        <h1 class="flex-1">{{ __('butik::order.plural') }}</h1>
    </div>

    @unless($orders->isEmpty())

        <butik-order-list
            :initial-rows="{{ json_encode($orders) }}"
            :columns="{{ json_encode($columns) }}"
            :endpoints="{}">
        ></butik-order-list>

    @else

        <div class="card">
            {{ __('butik::general.id') }}
        </div>

    @endunless

@endsection
